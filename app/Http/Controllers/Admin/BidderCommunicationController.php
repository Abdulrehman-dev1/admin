<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Auction;
use App\Models\User;
use App\Models\Bid;
use Illuminate\Support\Facades\Mail;
use App\Mail\CustomBidderMessage;
use App\Services\MsgpkService;

class BidderCommunicationController extends Controller
{
    protected $msgpkService;

    public function __construct(MsgpkService $msgpkService)
    {
        $this->msgpkService = $msgpkService;
    }

    public function index()
    {
        return view('admin.bidder_communication.index');
    }

    public function getProducts(Request $request)
    {
        $type = $request->get('type');
        \Log::info("BidderComm: getProducts called with type: $type");

        // Start with a base query
        $query = Auction::query(); 
        // Removed status check to allow messaging for closed auctions too

        if ($type === '1_rupee') {
            $query->where(function($q) {
                $q->where('is_1_rupee', 1)
                  ->orWhere('is_1_rupee', true)
                  ->orWhere('is_1_rupee', '1');
            });
        } else {
            $query->where(function($q) {
                $q->where('is_1_rupee', 0)
                  ->orWhere('is_1_rupee', false)
                  ->orWhereNull('is_1_rupee');
            });
        }
        
        $products = $query->select('id', 'title')->orderBy('created_at', 'desc')->get();
        \Log::info("BidderComm: Found " . $products->count() . " products.");

        return response()->json($products);
    }

    public function getBidders(Request $request)
    {
        $productId = $request->get('product_id');
        // Assuming relationship: Auction -> Bids -> User
        // Or directly from bids table
        $bidders = \App\Models\Bid::where('auction_id', $productId)
                    ->with('user:id,name,email,phone,profile_pic')
                    ->get()
                    ->pluck('user')
                    ->unique('id')
                    ->values();

        return response()->json($bidders);
    }

    public function searchUsers(Request $request)
    {
        $term = $request->get('q');
        $query = User::query();

        if (!empty($term)) {
            $query->where('name', 'like', "%$term%")
                  ->orWhere('email', 'like', "%$term%")
                  ->orWhere('phone', 'like', "%$term%");
        } else {
            // Limit initial load if no search term to prevent massive payload
            $query->limit(50);
        }

        $users = $query->select('id', 'name', 'email', 'phone', 'profile_pic')->get();
        return response()->json($users);
    }

    public function send(Request $request)
    {
        $request->validate([
            'subject' => 'required|string',
            'message' => 'required|string',
        ]);

        // Merge IDs from both tabs (only one should be active/filled theoretically, but we can accept both)
        $userIds = $request->input('user_ids', []);
        $directUserIds = $request->input('direct_user_ids', []);

        if (empty($userIds) && empty($directUserIds)) {
            return redirect()->back()->with('error', 'Please select at least one user.');
        }

        $allUserIds = array_unique(array_merge($userIds ?? [], $directUserIds ?? []));
        
        $subject = $request->subject;
        $rawMessage = $request->message;

        $sentCount = 0;

        foreach ($allUserIds as $userId) {
            $user = User::find($userId);
            if (!$user) continue;

            // Replace variables
            $personalMessage = str_replace('{{user_name}}', $user->name, $rawMessage);

            // 1. Try Email
            if (!empty($user->email)) {
                try {
                    Mail::to($user->email)->send(new CustomBidderMessage($subject, $personalMessage));
                    $sentCount++;
                    continue; // Done with this user
                } catch (\Exception $e) {
                    \Log::error("Failed to email user {$user->id}: " . $e->getMessage());
                    // Fallback to SMS below
                }
            }

            // 2. Fallback to SMS if email missing or failed
            if (!empty($user->phone)) {
                try {
                    // Convert HTML to plain text for SMS
                    $smsContent = $personalMessage;

                    // 1. Decode entities first (in case input is escaped like &lt;h1&gt;)
                    $smsContent = html_entity_decode($smsContent);

                    // 2. Replace <br> and block tags with newlines
                    $smsContent = preg_replace('/<br\s*\/?>/i', "\n", $smsContent);
                    $smsContent = preg_replace('/<\/(p|div|h[1-6]|li)>/i', "\n", $smsContent);
                    $smsContent = preg_replace('/<ul|ol>/i', "\n", $smsContent);
                    
                    // 3. Extract Links: <a href="URL">Text</a> -> Text (URL)
                    $smsContent = preg_replace_callback('/<a\s+(?:[^>]*?\s+)?href="([^"]*)"[^>]*>(.*?)<\/a>/i', function($matches) {
                        $url = $matches[1];
                        $text = $matches[2];
                        return $text . " (" . $url . ")";
                    }, $smsContent);

                    // 4. Strip tags
                    $smsContent = strip_tags($smsContent);

                    // 5. Cleanup whitespace
                    // Replace multiple newlines with double newline
                    $smsContent = preg_replace("/[\r\n]{3,}/", "\n\n", $smsContent);
                    $smsContent = trim($smsContent);
                    
                    // maybe limit length?
                    $this->msgpkService->sendMessage($user->phone, $smsContent);
                    $sentCount++;
                } catch (\Exception $e) {
                    \Log::error("Failed to SMS user {$user->id}: " . $e->getMessage());
                }
            }
        }

        return redirect()->back()->with('success', "Message sent to $sentCount users.");
    }
}
