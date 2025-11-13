<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Auction;
use App\Models\Bid;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AutoBidCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'auto:bid';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Automatically place bids on all active auctions using dummy user accounts (runs every 4 hours)';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🤖 Starting Auto Bid Process...');

        // Get all dummy users (IDs 328-347)
        $dummyUsers = User::whereBetween('id', [328, 347])
            ->where('status', 'active')
            ->get();

        if ($dummyUsers->isEmpty()) {
            $this->error('❌ No dummy users found (IDs 328-347). Please run DummyUsersSeeder first.');
            return 1;
        }

        $this->info("✅ Found {$dummyUsers->count()} dummy users");

        // Get all active auctions that have auto bidder enabled and haven't ended
        $activeAuctions = Auction::where('status', 'active')
            ->where('is_autobidder_on', true)
            ->where('end_date', '>', now())
            ->orderBy('id', 'asc')
            ->get();

        if ($activeAuctions->isEmpty()) {
            $this->warn('⚠️  No active auto-bid enabled auctions found.');
            return 0;
        }

        $this->info("🎯 Found {$activeAuctions->count()} active auto-bid enabled auctions");

        $bidsPlaced = 0;
        $errors = 0;

        foreach ($activeAuctions as $index => $auction) {
            try {
                // Get which users have already bid on this auction
                $biddedUserIds = Bid::where('auction_id', $auction->id)
                    ->whereIn('user_id', $dummyUsers->pluck('id')->toArray())
                    ->pluck('user_id')
                    ->toArray();

                // Find next user in rotation who hasn't bid on this auction yet
                $availableUsers = $dummyUsers->filter(function ($user) use ($biddedUserIds) {
                    return !in_array($user->id, $biddedUserIds);
                });

                // If all users have bid on this auction, reset rotation (allow any user)
                if ($availableUsers->isEmpty()) {
                    $availableUsers = $dummyUsers;
                    $this->warn("  ⚠️  Auction #{$auction->id}: All users have bid, rotating...");
                }

                // Round-robin: For each auction, use next user in sequence
                // Each auction gets a different starting user index
                $userIndexForAuction = $index % $availableUsers->count();
                $selectedUser = $availableUsers->values()[$userIndexForAuction];

                // Get current highest bid for this auction
                $currentHighestBid = Bid::where('auction_id', $auction->id)
                    ->orderBy('bid_amount', 'desc')
                    ->value('bid_amount') ?? 0;

                // Calculate new bid amount
                // Use bid_increment if available, otherwise add 10 AED or use minimum_bid + 10
                $minBid = (float) ($auction->minimum_bid ?? 0);
                $bidIncrement = (float) ($auction->bid_increment ?? 10);
                
                $newBidAmount = max(
                    (float) $currentHighestBid + $bidIncrement,
                    $minBid + $bidIncrement
                );

                // Ensure bid is at least minimum_bid
                if ($newBidAmount < $minBid) {
                    $newBidAmount = $minBid + $bidIncrement;
                }

                // Place bid using database transaction
                DB::beginTransaction();
                try {
                    // Double-check auction is still active (race condition protection)
                    $auction->refresh();
                    if ($auction->status !== 'active' || now()->greaterThan($auction->end_date)) {
                        DB::rollBack();
                        $this->warn("  ⏭️  Auction #{$auction->id} is no longer active, skipping...");
                        continue;
                    }

                    // Double-check highest bid hasn't changed (race condition protection)
                    $latestHighestBid = Bid::where('auction_id', $auction->id)
                        ->orderBy('bid_amount', 'desc')
                        ->value('bid_amount') ?? 0;

                    if ($newBidAmount <= $latestHighestBid) {
                        $newBidAmount = $latestHighestBid + $bidIncrement;
                    }

                    // Create the bid
                    $bid = Bid::create([
                        'user_id' => $selectedUser->id,
                        'auction_id' => $auction->id,
                        'bid_amount' => $newBidAmount,
                    ]);

                    DB::commit();

                    $bidsPlaced++;
                    $this->info("  ✅ Bid placed: User #{$selectedUser->id} ({$selectedUser->name}) bid AED {$newBidAmount} on Auction #{$auction->id} ({$auction->title})");

                    // Small delay to avoid race conditions
                    usleep(100000); // 0.1 seconds

                } catch (\Exception $e) {
                    DB::rollBack();
                    $errors++;
                    $this->error("  ❌ Error placing bid on Auction #{$auction->id}: " . $e->getMessage());
                    Log::error("AutoBid Error - Auction: {$auction->id}, User: {$selectedUser->id}", [
                        'error' => $e->getMessage(),
                        'trace' => $e->getTraceAsString()
                    ]);
                }

            } catch (\Exception $e) {
                $errors++;
                $this->error("  ❌ Error processing Auction #{$auction->id}: " . $e->getMessage());
                Log::error("AutoBid Error - Auction: {$auction->id}", [
                    'error' => $e->getMessage()
                ]);
            }
        }

        // Summary
        $this->newLine();
        $this->info("📊 Summary:");
        $this->info("  ✅ Bids Placed: {$bidsPlaced}");
        $this->info("  ❌ Errors: {$errors}");
        $this->info("  🎯 Auctions Processed: {$activeAuctions->count()}");

        if ($bidsPlaced > 0) {
            Log::info("AutoBid Completed", [
                'bids_placed' => $bidsPlaced,
                'errors' => $errors,
                'auctions_processed' => $activeAuctions->count()
            ]);
        }

        return 0;
    }
}

