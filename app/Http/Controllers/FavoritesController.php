<?php
// app/Http/Controllers/FavoriteController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

use App\Models\Favorite;

class FavoritesController extends Controller
{
  public function index(Request $request)
    {
        $user = $request->user();
        //dd($user);
        $favorites = Favorite::where('user_id', $user->id)
        ->with(['auction' => function ($query) {
            $query->with('bids'); // Load bids with the auction
        }])
        ->get()
        ->map(function ($favorite) {
            $highestBid = $favorite->auction->bids->max('bid_amount'); // Get the highest bid

            return [
                'id' => $favorite->auction->id,
                'name' => $favorite->auction->title,
                'image' => $favorite->auction->image,
                'currentBid' => $highestBid, // Assign the highest bid
                'minimum_bid' =>$favorite->auction->minimum_bid,
                'start_date' => $favorite->auction->start_date,
                'end_date' => $favorite->auction->end_date,
            ];
        });



        return response()->json(['favorites' => $favorites]);
    }
    public function check(Request $request){

        $favor = Favorite::where("user_id",$request->user_id)->where("auctions_id",$request->auction_id)->first();
        //dd($request);
        if($favor){
            return response()->json([
                'success' => true
            ]);
        }
        return response()->json([
            'success' => false
        ]);
    }
    public function add(Request $request){
        $favor = Favorite::where("user_id",$request->user_id)->where("auctions_id",$request->auction_id)->first();
        if($favor){
            $favor->delete();
            return response()->json([
                'success' => true,
                'message' => "Successfully Delete",

            ]);
        }else{

            $Favorite = Favorite::create([
                "user_id" => $request->user_id,
                "auctions_id" => $request->auction_id,
            ]);

            return response()->json([
                'success' => true,
                'message' => "Successfully Added",

            ]);
        }
    }
}
