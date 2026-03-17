<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Auction;
use App\Models\Bid;
use App\Models\NewNotification;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\AuctionClosedMail;
use App\Mail\AuctionAwardedMail;

class CheckAuctionStatusCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'auction:check-status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check and update auction status for expired auctions (runs every minute)';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🔄 Starting Auction Status Check Process...');

        // 1. Fetch auctions where (standard end_date < now AND is_live_auction=0) 
        // OR (live_auction_date + live_auction_end_time < now AND is_live_auction=1)
        // AND status is eligible for running auction lifecycle
        $expiredAuctions = Auction::whereIn('status', ['active', 'private'])
            ->where(function ($query) {
                $now = Carbon::now('Asia/Karachi'); // Use Karachi time for comparison
                
                // If end_date is set (standard OR extended live), use it
                $query->where(function ($q) use ($now) {
                    $q->whereNotNull('end_date')
                      ->where('end_date', '!=', 'Not set')
                      ->where('end_date', '<', $now->format('Y-m-d H:i:s'));
                })
                // Otherwise, if it's a live auction without an end_date yet, use live fields
                ->orWhere(function ($q) use ($now) {
                    $q->where(function($sub) {
                        $sub->whereNull('end_date')->orWhere('end_date', 'Not set');
                    })
                    ->where('is_live_auction', 1)
                    ->whereNotNull('live_auction_date')
                    ->whereNotNull('live_auction_end_time')
                    ->whereRaw("CONCAT(live_auction_date, ' ', live_auction_end_time) < ?", [$now->format('Y-m-d H:i:s')]);
                });
            })
            ->get();


        if ($expiredAuctions->isEmpty()) {
            $this->info('✅ No expired auctions found.');
            return 0;
        }

        $this->info("🎯 Found {$expiredAuctions->count()} expired auction(s) to process");

        $awardedCount = 0;
        $closedCount = 0;
        $errors = 0;

        foreach ($expiredAuctions as $auction) {
            try {
                // 2. Check highest bid
                $highestBid = Bid::where('auction_id', $auction->id)
                    ->orderBy('bid_amount', 'desc')
                    ->first();

                // 3. If any bid exists, award the auction to the highest bidder.
                if ($highestBid) {
                    // Auction is awarded to the highest bidder
                    $auction->status = 'awarded';
                    $auction->winner_id = $highestBid->user_id;
                    $auction->save();
                    
                    $awardedCount++;
                    $this->info("  ✅ Auction #{$auction->id} ({$auction->title}) - Awarded to User #{$highestBid->user_id} (Bid: AED {$highestBid->bid_amount})");

                    // Reload auction with relationships
                    $auction->load(['user', 'winner']);
                    $highestBid->load('user');

                    try {
                        // Send email to winner
                        if ($highestBid->user && $highestBid->user->email) {
                            Mail::to($highestBid->user->email)->send(new AuctionAwardedMail($auction, $highestBid, 'winner'));
                            $this->info("    📧 Email sent to winner: {$highestBid->user->email}");
                        }

                        // Send email to admin
                        Mail::to('xpertbidofficial@gmail.com')->send(new AuctionAwardedMail($auction, $highestBid, 'admin'));
                        $this->info("    📧 Email sent to admin");

                        // Send notification to winner
                        if ($highestBid->user) {
                            NewNotification::create([
                                'user_id' => $highestBid->user_id,
                                'title' => 'Congratulations! You Won the Auction',
                                'message' => "You have won the auction for \"{$auction->title}\" with a bid of AED " . number_format($highestBid->bid_amount, 2),
                                'type' => 'auction',
                                'image_url' => NewNotification::getImageForType('auction'),
                            ]);
                            $this->info("    🔔 Notification sent to winner");
                        }
                    } catch (\Exception $emailError) {
                        Log::error("Error sending award emails/notifications for Auction #{$auction->id}: " . $emailError->getMessage());
                        $this->warn("    ⚠️  Failed to send emails/notifications: " . $emailError->getMessage());
                    }

                } else {
                    // Otherwise, no bids => mark as closed
                    $auction->status = 'closed';
                    $auction->save();
                    
                    $closedCount++;
                    $this->warn("  ⚠️  Auction #{$auction->id} ({$auction->title}) - Closed (No valid bids)");

                    // Reload auction with seller relationship
                    $auction->load('user');

                    try {
                        // Send email to seller
                        if ($auction->user && $auction->user->email) {
                            Mail::to($auction->user->email)->send(new AuctionClosedMail($auction, 'seller'));
                            $this->info("    📧 Email sent to seller: {$auction->user->email}");
                        }

                        // Send email to admin
                        Mail::to('xpertbidofficial@gmail.com')->send(new AuctionClosedMail($auction, 'admin'));
                        $this->info("    📧 Email sent to admin");

                        // Send notification to seller
                        if ($auction->user) {
                            NewNotification::create([
                                'user_id' => $auction->user_id,
                                'title' => 'Your Auction Has Been Closed',
                                'message' => "Your auction \"{$auction->title}\" has been closed as it ended without valid bids.",
                                'type' => 'auction',
                                'image_url' => NewNotification::getImageForType('auction'),
                            ]);
                            $this->info("    🔔 Notification sent to seller");
                        }
                    } catch (\Exception $emailError) {
                        Log::error("Error sending closed emails/notifications for Auction #{$auction->id}: " . $emailError->getMessage());
                        $this->warn("    ⚠️  Failed to send emails/notifications: " . $emailError->getMessage());
                    }
                }

            } catch (\Exception $e) {
                $errors++;
                $this->error("  ❌ Error processing Auction #{$auction->id}: " . $e->getMessage());
                Log::error("CheckAuctionStatus Error - Auction: {$auction->id}", [
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);
            }
        }

        // Summary
        $this->newLine();
        $this->info("📊 Summary:");
        $this->info("  ✅ Awarded: {$awardedCount}");
        $this->info("  ⚠️  Closed: {$closedCount}");
        $this->info("  ❌ Errors: {$errors}");
        $this->info("  🎯 Total Processed: {$expiredAuctions->count()}");

        if ($awardedCount > 0 || $closedCount > 0) {
            Log::info("CheckAuctionStatus Completed", [
                'awarded' => $awardedCount,
                'closed' => $closedCount,
                'errors' => $errors,
                'total_processed' => $expiredAuctions->count()
            ]);
        }

        return 0;
    }
}
