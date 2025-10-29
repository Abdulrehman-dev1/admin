<?php
namespace App\Http\Controllers;

use App\Models\Wallet;
use App\Models\Bid;
use App\Models\User;
use App\Models\Auction;
use Illuminate\Http\Request;
use App\Models\NewNotification;
use App\Mail\BidPlacedConfirmation;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use App\Models\IndividualVerification;
use App\Models\CorporateVerification;
use App\Mail\BidOutbidNotification;


class BidController extends Controller
{
    public function getHighestBid($auctionId)
    {
        $highestBid = Bid::where('auction_id', $auctionId)
            ->orderBy('bid_amount', 'desc')
            ->first();

        if ($highestBid) {
            return response()->json([
                'success' => true,
                'highest_bid' => $highestBid->bid_amount,
                'user' => $highestBid->user->name ?? 'Anonymous',
            ]);
        } else {
            return response()->json([
                'success' => true,
                'highest_bid' => 0,
                'user' => null,
            ]);
        }
    }
    
public function placeBid(Request $request)
{
    // 1) Validate input
    $request->validate([
        'auction_id' => 'required|exists:auctions,id',
        'bid_amount' => 'required|numeric|min:1',
    ], [
        'bid_amount.required' => 'Please enter your bid amount.',
        'bid_amount.numeric'  => 'Bid amount must be a valid number.',
        'bid_amount.min'      => 'Your bid must be at least 1.',
    ]);

    $userId = auth()->id();

    // 2) Load auction and ensure active & not ended
    $auction = Auction::findOrFail($request->auction_id);

    if ($auction->status !== 'active' || now()->greaterThan($auction->end_date)) {
        return response()->json([
            'success' => false,
            'message' => 'This auction has ended or is no longer active.',
        ], 400);
    }

    // 3) Enforce min bid and strictly higher than current highest
    $minBid = (float) ($auction->minimum_bid ?? 0);

    $currentHighestBid = Bid::where('auction_id', $auction->id)
        ->orderBy('bid_amount', 'desc')
        ->first();

    $newAmount = (float) $request->bid_amount;

    if ($newAmount < $minBid) {
        return response()->json([
            'success' => false,
            'message' => 'Your bid must be greater than or equal to the minimum bid.',
            'min_bid' => $minBid,
        ], 400);
    }

    if ($currentHighestBid && $newAmount <= (float) $currentHighestBid->bid_amount) {
        return response()->json([
            'success' => false,
            'message' => 'Your bid must be higher than the current highest bid.',
            'current_highest' => (float) $currentHighestBid->bid_amount,
        ], 400);
    }

    // 4) Create bid (no verification/wallet checks)
    DB::beginTransaction();
    try {
        $bid = Bid::create([
            'user_id'    => $userId,
            'auction_id' => $auction->id,
            'bid_amount' => $newAmount, // Expecting AED amount from frontend
        ]);

        // Optional: notify or email
        // $this->sendBidNotification($auction->id, $userId);
        // Mail::to(auth()->user()->email)->send(new BidPlacedConfirmation(...));

        DB::commit();

        return response()->json([
            'success' => true,
            'message' => 'Bid placed successfully!',
            'bid_id'  => $bid->id,
        ]);
    } catch (\Throwable $e) {
        DB::rollBack();
        return response()->json([
            'success' => false,
            'message' => 'An error occurred while processing your bid: ' . $e->getMessage(),
        ], 500);
    }
}

    
    public function sendBidNotification($auctionId, $currentUserId)
    {
        // Get auction details
        $auction = Auction::find($auctionId);
        // New highest bid for the auction
        $newHighestBid = Bid::where('auction_id', $auctionId)
                            ->orderBy('bid_amount', 'desc')
                            ->first()->bid_amount;
        // Dashboard link for the user
        $dashboardLink = url('https://www.xpertbid.com/userDashboard');

        // Get last 3 unique bidders excluding the current user
        $previousBidders = Bid::where('auction_id', $auctionId)
            ->where('user_id', '!=', $currentUserId)
            ->groupBy('user_id')
            ->orderBy('created_at', 'desc')
            ->limit(3)
            ->pluck('user_id');

        // Loop through each bidder to create a DB notification and send an email
        foreach ($previousBidders as $bidderId) {
            // Create database notification
            NewNotification::create([
                'user_id'    => $bidderId,
                'auction_id' => $auctionId,
                'title'      => "Someone placed a higher bid than you in Auction #$auctionId",
                'message'    => "Someone placed a higher bid than you in Auction #$auctionId",
                'type'       => 'bid',
                'image_url'  => '/assets/images/message-text.svg',
            ]);

            // Get the highest bid amount that this bidder placed
            $userBidAmount = Bid::where('auction_id', $auctionId)
                                ->where('user_id', $bidderId)
                                ->max('bid_amount');

            // Retrieve bidder details
            $user = User::find($bidderId);
            if ($user && $user->email) {
                // Send email using BidOutbidNotification mailable
                Mail::to($user->email)
                    ->send(new BidOutbidNotification($user->name, $auction->title, $userBidAmount, $newHighestBid, $dashboardLink));
            }
        }
    }

}
