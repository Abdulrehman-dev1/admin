<?php

namespace App\Jobs;

use App\Models\Auction;
use Illuminate\Bus\Queueable;
use Carbon\Carbon;
use App\Models\Bid;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;

class CheckAuctionStatusJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle()
    {   //echo "job code run";
        // 1. Fetch auctions where end_date < now AND status = 'active'
        $expiredAuctions = Auction::where('status', 'active')
            ->where('end_date', '<', Carbon::now())
            ->get();
     // dd($expiredAuctions->toSql());
//Log::info('Found expired auctions: ', [$expiredAuctions->toSql()]);
        
        foreach ($expiredAuctions as $auction) {

            // 2. Check highest bid
            $highestBid = Bid::where('auction_id', $auction->id)
                ->orderBy('bid_amount', 'desc')
                ->first();

            // 3. Compare highest bid amount with reserve_price (or minimum_bid if you prefer)
            if ($highestBid && $highestBid->bid_amount >= $auction->reserve_price) {
                // Auction is awarded to the highest bidder
                $auction->status = 'awarded';
                $auction->winner_id = $highestBid->user_id; // if you keep track of winner
                $auction->save();
                
               // Log::info('Processing auction ID: '.$auction->id);

                // 4. Send notification to the winner
                // (a) via email (Laravel Mail or Notification)
                // (b) via OneSignal push if you have that integrated
            } else {
                // Otherwise, no valid bids => mark as closed
                $auction->status = 'closed';
                $auction->save();
            }
        }
       // Log::info('CheckAuctionStatusJob finished at: '. now());
    }
}
