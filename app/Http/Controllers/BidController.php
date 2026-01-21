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
use App\Services\MsgpkService;


class BidController extends Controller
{
    protected $msgpkService;

    public function __construct(MsgpkService $msgpkService)
    {
        $this->msgpkService = $msgpkService;
    }

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
        // ------------------------------------------------------------
        // Verification gate: allow if EITHER Individual OR Corporate is approved
        // ------------------------------------------------------------
        $userIdForGate = auth()->id();

        $individualGate = IndividualVerification::where('user_id', $userIdForGate)->first();
        $corporateGate = CorporateVerification::where('user_id', $userIdForGate)->first();

        // helper closures
        $isApprovedGate = function ($rec) {
            if (!$rec)
                return false;
            return in_array(strtolower($rec->status), ['approved', 'verified'], true);
        };
        $isPendingGate = function ($rec) {
            if (!$rec)
                return false;
            return in_array(strtolower($rec->status), ['pending', 'not_verified', 'submitted'], true);
        };
        $isRejectedGate = function ($rec) {
            if (!$rec)
                return false;
            return in_array(strtolower($rec->status), ['rejected', 'declined'], true);
        };

        $verificationUrlGate = 'https://xpertbid.com/account?tab=identity_verification';

        // Case A: neither record exists
        if (!$individualGate && !$corporateGate) {

            return response()->json([
                'success' => false,
                'is_verified' => false,
                'message' => 'You need to complete verification before placing a bid. Please verify your identity (individual or corporate).',
                'verify_url' => $verificationUrlGate,
                'which' => 'none',
            ], 403);
        }

        // Case B: approved if either side approved
        if ($isApprovedGate($individualGate) || $isApprovedGate($corporateGate)) {
            // pass
        } else {
            // Not approved anywhere — tell most relevant state
            if ($isPendingGate($individualGate) || $isPendingGate($corporateGate)) {

                return response()->json([
                    'success' => false,
                    'is_verified' => false,
                    'message' => 'Your verification has been submitted and is currently pending review.',
                    'verify_url' => $verificationUrlGate,
                    'which' => $isPendingGate($corporateGate) ? 'corporate' : 'individual',
                ], 403);
            }

            if ($isRejectedGate($individualGate) || $isRejectedGate($corporateGate)) {
                return response()->json([
                    'success' => false,
                    'is_verified' => false,
                    'message' => 'Your verification was rejected. Please resubmit the required documents.',
                    'verify_url' => $verificationUrlGate,
                    'which' => $isRejectedGate($corporateGate) ? 'corporate' : 'individual',
                ], 403);
            }

            // Fallback: some unknown status
            return response()->json([
                'success' => false,
                'is_verified' => false,
                'message' => 'Verification is not complete. Please complete verification to proceed.',
                'verify_url' => $verificationUrlGate,
                'which' => ($individualGate ? 'individual' : 'corporate'),
                'debug_status' => [
                    'individual' => $individualGate->status ?? null,
                    'corporate' => $corporateGate->status ?? null,
                ],
            ], 403);
        }

        // 1) Validate input
        $request->validate([
            'auction_id' => 'required|exists:auctions,id',
            'bid_amount' => 'required|numeric|min:1',
        ], [
            'bid_amount.required' => 'Please enter your bid amount.',
            'bid_amount.numeric' => 'Bid amount must be a valid number.',
            'bid_amount.min' => 'Your bid must be at least 1.',
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
                'user_id' => $userId,
                'auction_id' => $auction->id,
                'bid_amount' => $newAmount, // Expecting AED amount from frontend
            ]);

            // Optional: notify or email
            $this->sendBidNotification($auction->id, $userId);
            // Mail::to(auth()->user()->email)->send(new BidPlacedConfirmation(...));

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Bid placed successfully!',
                'bid_id' => $bid->id,
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
        // Product link for the user
        $productLink = 'https://www.xpertbid.com/product/' . $auction->slug;

        // Get last 5 unique bidders excluding the current user
        $previousBidders = Bid::where('auction_id', $auctionId)
            ->where('user_id', '!=', $currentUserId)
            ->groupBy('user_id')
            ->orderBy('created_at', 'desc')
            ->take(5) // Limit to last 5 unique bidders
            ->pluck('user_id');
            
        // Loop through each bidder to create a DB notification and send an email/SMS
        foreach ($previousBidders as $bidderId) {
            // Create database notification
            NewNotification::create([
                'user_id' => $bidderId,
                'auction_id' => $auctionId,
                'title' => "Someone placed a higher bid than you in Auction #$auctionId",
                'message' => "Someone placed a higher bid than you in Auction #$auctionId",
                'type' => 'bid',
                'image_url' => '/assets/images/message-text.svg',
            ]);

            // Retrieve bidder details
            $user = User::find($bidderId);
            
            if ($user) {
                if (!empty($user->email)) {
                     // Get the highest bid amount that this bidder placed (needed for email template)
                     $userBidAmount = Bid::where('auction_id', $auctionId)
                        ->where('user_id', $bidderId)
                        ->max('bid_amount');

                    // Send email using BidOutbidNotification mailable
                    try {
                        Mail::to($user->email)
                            ->send(new BidOutbidNotification($user->name, $auction->title, $userBidAmount, $newHighestBid, $productLink));
                    } catch (\Exception $e) {
                        \Log::error("Failed to send outbid email to {$user->email}: " . $e->getMessage());
                    }
                } elseif (!empty($user->phone)) {
                    // Send SMS via Msgpk if email is missing but phone exists
                    $message = "Alert: You've been outbid on '{$auction->title}'. New highest: {$newHighestBid}. Bid Now: {$productLink}";
                    $this->msgpkService->sendMessage($user->phone, $message);
                }
            }
        }
    }

    public function index(Request $request)
    {
        $query = Bid::with(['user.IndividualVerification', 'auction']);

        // Search functionality (Auction Title, Bid ID, User Name, User Phone)
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('id', 'LIKE', "%$search%")
                    ->orWhere('bid_amount', 'LIKE', "%$search%")
                    ->orWhereHas('auction', function ($aq) use ($search) {
                        $aq->where('title', 'LIKE', "%$search%");
                    })
                    ->orWhereHas('user', function ($uq) use ($search) {
                        $uq->where('name', 'LIKE', "%$search%")
                            ->orWhere('phone', 'LIKE', "%$search%")
                            ->orWhereHas('IndividualVerification', function ($ivq) use ($search) {
                                $ivq->where('contact_number', 'LIKE', "%$search%");
                            });
                    });
            });
        }

        // Date Range filtering
        if ($request->has('date_range') && !empty($request->date_range)) {
            $dates = explode(' to ', $request->date_range);
            if (count($dates) == 2) {
                $query->whereDate('created_at', '>=', $dates[0])
                    ->whereDate('created_at', '<=', $dates[1]);
            } else {
                $query->whereDate('created_at', $dates[0]);
            }
        }

        // Sorting
        $sort = $request->get('sort', 'newest_to_oldest');
        switch ($sort) {
            case 'oldest_to_newest':
                $query->orderBy('created_at', 'asc');
                break;
            case 'high_to_low':
                $query->orderBy('bid_amount', 'desc');
                break;
            case 'low_to_high':
                $query->orderBy('bid_amount', 'asc');
                break;
            case 'newest_to_oldest':
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }

        $bids = $query->paginate(15)->withQueryString();

        if ($request->ajax()) {
            return view('bids.table_partial', compact('bids'))->render();
        }

        return view('bids.index', compact('bids'));
    }

    public function show($id)
    {
        $bid = Bid::with(['user.IndividualVerification', 'auction.user'])->findOrFail($id);

        // All bids for this specific auction
        $auctionBids = Bid::with('user.IndividualVerification')
            ->where('auction_id', $bid->auction_id)
            ->latest()
            ->get();

        return view('bids.show', compact('bid', 'auctionBids'));
    }
}
