<?php
namespace App\Http\Controllers;

use App\Models\Auction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\AuctionDeclinedMail;
use App\Mail\AuctionAcceptedMail;

class AuctionStatusController extends Controller
{
   // INDEX: List all auctions with status
    public function index(Request $request)
{
    $search  = trim($request->q ?? '');
    $status  = $request->status;
    $perPage = (int) ($request->per_page ?? 10);

    $allowedStatuses = ['inactive', 'decline', 'resubmit'];

    $query = Auction::with(['user', 'category'])
        ->whereIn('status', $allowedStatuses);

    // optional single-status filter
    if ($status && in_array($status, $allowedStatuses, true)) {
        $query->where('status', $status);
    }

    // search across title, id, user.name, category.name
    if ($search !== '') {
        $query->where(function ($q) use ($search) {
            $q->where('title', 'like', "%{$search}%")
              ->orWhere('id', $search)
              ->orWhereHas('user', fn($uq) => $uq->where('name', 'like', "%{$search}%"))
              ->orWhereHas('category', fn($cq) => $cq->where('name', 'like', "%{$search}%"));
        });
    }

    $auctions = $query->latest()->paginate($perPage)->withQueryString();

    return view('auctionstatus.index', compact('auctions', 'allowedStatuses'));
}
   public function edit($id)
{
    // Auction + related user, category, property & vehicle details la lo
    $auction = \App\Models\Auction::with([
        'user', // User relation
        'category', // Auction category
          'subCategory',
    'childCategory',
        'property_verification', // use snake_case
    'vehicle_verification',  // use snake_case
    ])->findOrFail($id);

    return view('auctionstatus.edit', compact('auction'));
}

    public function update(Request $request, $id)
    {
        $auction = Auction::findOrFail($id);
        $action  = $request->input('action');

        if ($action === 'accept') {
            $auction->status = 'active';
        } elseif ($action === 'decline') {
            $auction->status = 'inactive';
        }
        $auction->decline_reason = null;
        $auction->save();

        return redirect()
            ->route('auctionstatus.index', $auction->id)
            ->with('success', "Auction {$action}d.");
    }

    
  public function decline(Request $request, $id)
{
    $request->validate([
        'decline_reason' => 'required|string|max:1000',
    ]);

    $auction = Auction::findOrFail($id);

    $auction->status = 'decline';
    $auction->decline_reason = $request->decline_reason;
    $auction->save();

    // In-app notification
    \App\Models\NewNotification::create([
        'user_id'   => $auction->user_id,
        'title'     => 'Auction Declined',
        'message'   => "Your auction \"{$auction->title}\" was declined: {$request->decline_reason}",
        'type'      => 'auction',
        'image_url' => \App\Models\NewNotification::getImageForType('auction'),
        'read_at'   => null,
    ]);

    // User ko mail send karo
    $user = $auction->user;
    if ($user && $user->email) {
        $editUrl = "http://xpertbid.com/sell/edit/" . $auction->id;
        Mail::to($user->email)->send(new AuctionDeclinedMail($auction, $editUrl));
    }

    return redirect()->route('auctionstatus.index')->with('success', 'Auction declined and user notified!');
}

public function accept($id)
{
    $auction = \App\Models\Auction::findOrFail($id);
    $auction->status = 'active';
    $auction->decline_reason = null;
    $auction->save();

    // In-app notification
    \App\Models\NewNotification::create([
        'user_id'   => $auction->user_id,
        'title'     => 'Auction Accepted',
        'message'   => "Your auction \"{$auction->title}\" has been approved and is now live.",
        'type'      => 'auction',
        'image_url' => \App\Models\NewNotification::getImageForType('auction'),
        'read_at'   => null,
    ]);

    // Mail user
    $user = $auction->user;
    if ($user && $user->email) {
        Mail::to($user->email)->send(new AuctionAcceptedMail($auction));
    }

    return redirect()->route('auctionstatus.index')->with('success', 'Auction accepted and user notified.');
}

}
