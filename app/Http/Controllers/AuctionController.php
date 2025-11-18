<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Auction;
use App\Models\User;
use App\Models\AuctionCategory;
use App\Models\Subcategory;
use App\Models\Seo;
use App\Models\Bid;
use App\Models\Country;
use App\Models\City;
use Illuminate\Support\Str;     
use App\Models\State;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Services\OneSignalService;
use App\Models\Wallet;
use App\Mail\AuctionLostNotification;
use App\Mail\AuctionNewListingNotification;
use App\Mail\AuctionWonNotification;
use Illuminate\Support\Facades\Mail;
use App\Models\IndividualVerification;
use App\Models\CorporateVerification;
use Illuminate\Support\Carbon;      //  import Carbon here
use App\Mail\AuctionStatusUpdated;

class AuctionController extends Controller
{
    public function index()
    {
        //$sellers = User::where('role', 'seller')->get();
        $auctions = Auction::get()->sortByDesc('created_at');

        return view('auction.index', compact('auctions'));
    }

 public function create()
    {
        $users         = User::all();
        $categories    = AuctionCategory::whereNull('parent_id')
                             ->whereNull('sub_category_id')
                             ->get();
        $subCategories = AuctionCategory::with('subcategories')->get();

        // blank model so $auction->… never errors
        $auction = new Auction;

        return view('auction.create', compact(
            'auction','users','categories','subCategories'
        ));
    }

    /// new//
  public function store(Request $request)
{
    // Base rules
    $listType = $request->input('list_type', 'auction');
    $rules = [
        'title'             => ['required','string','min:2','max:100'],
        'user_id'           => ['required','integer','exists:users,id'],
        'category_id'       => ['required','integer','exists:auction_categories,id'],
        'sub_category_id'   => ['nullable','integer','exists:auction_categories,id'],
        'child_category_id' => ['nullable','integer','exists:auction_categories,id'],
        'description'       => ['required','string'],
        'list_type'         => ['required','in:auction,normal_list'],
    ];

    // Auction-specific rules
    if ($listType === 'auction') {
        $rules['start_date'] = ['required','date'];
        $rules['end_date'] = ['required','date','after_or_equal:start_date'];
        $rules['reserve_price'] = ['required','numeric'];
        $rules['minimum_bid'] = ['required','numeric'];
        $rules['product_year'] = ['required'];
        $rules['status'] = ['required'];
    }

    // Normal List-specific rules
    if ($listType === 'normal_list') {
        $rules['product_condition'] = ['required','in:new,old'];
        $rules['product_year'] = ['required'];
        $rules['minimum_bid'] = ['required','numeric']; // Price field
    }

    // New fields (optional by default)
    $rules += [
        'developer'            => ['nullable','string','max:255'],
        'location_url'         => ['nullable','max:1024'],
        'delivery_date'        => ['nullable','date'],
        'sale_starts'          => ['nullable','date'],
        'payment_plan'         => ['nullable','string'],
        'number_of_buildings'  => ['nullable','integer','min:0'],
        'government_fee'       => ['nullable','string'],
        'nearby_location'      => ['nullable','string'],
        'amenities'            => ['nullable','string'],
        'facilities'           => ['nullable','string'],
    ];

    $validated = $request->validate($rules);

    // Album upload (same as your logic)
    $albumsArray = [];
    if ($request->hasFile('album')) {
        $albumFiles = $request->file('album');
        if (!is_array($albumFiles)) $albumFiles = [$albumFiles];
        foreach ($albumFiles as $file) {
            $albumName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('/assets/images/auction/'), $albumName);
            $albumsArray[] = '/assets/images/auction/' . $albumName;
        }
    }

    // Persistable fields (old + new)
    $data = $request->only([
        'title','user_id','category_id','sub_category_id','child_category_id',
        'start_date','end_date','reserve_price','minimum_bid','description',
        'product_year','status','featured_name','create_category','list_type',
        'product_condition',
        // NEW:
        'developer','location_url','delivery_date','sale_starts','payment_plan',
        'number_of_buildings','government_fee','nearby_location','amenities','facilities',
    ]);

    // For normal_list, set default values
    if ($listType === 'normal_list') {
        if (empty($data['status'])) {
            $data['status'] = 'active';
        }
        // Set reserve_price to minimum_bid value or 0 if not provided
        if (empty($data['reserve_price']) || $data['reserve_price'] === null) {
            $data['reserve_price'] = !empty($data['minimum_bid']) ? $data['minimum_bid'] : 0;
        }
        // Set start_date and end_date to null or default values
        if (empty($data['start_date']) || $data['start_date'] === null) {
            $data['start_date'] = null;
        }
        if (empty($data['end_date']) || $data['end_date'] === null) {
            $data['end_date'] = null;
        }
    }

    $data['image'] = $albumsArray[0] ?? null;
    $data['album'] = json_encode($albumsArray);

    Auction::create($data);

    return redirect()->route('auctions.index')->with('success', 'Auction created successfully');
}


   
        public function filterAuctions(Request $request)
{
    // Get filter parameters from the request
    $categoryId = $request->input('category_id');
    $subCategoryId = $request->input('sub_category_id');
    $childCategoryId = $request->input('child_category_id');
    $priceRange = $request->input('price_range');

    // Convert price range to array (e.g., "0,300000" => [0, 300000])
    $priceRange = explode(',', $priceRange);
    $minPrice = isset($priceRange[0]) ? (float) $priceRange[0] : 0;
    $maxPrice = isset($priceRange[1]) ? (float) $priceRange[1] : 300000;

    // Start the query
    $query = Auction::where('status', 'active');

    // Apply filters if they exist
    if (!empty($categoryId)) {
        $query->where('category_id', $categoryId);
    }

    if (!empty($subCategoryId)) {
        $query->where('sub_category_id', $subCategoryId);
    }

    if (!empty($childCategoryId)) {
        $query->where('child_category_id', $childCategoryId);
    }

    if (!empty($status)) {
        $statusArray = explode(',', $status);
        $query->whereIn('status', $statusArray);
    }

    if ($minPrice !== null && $maxPrice !== null) {
        $query->whereBetween('reserve_price', [$minPrice, $maxPrice]);
    }

    // Get results
    $auctions = $query->with(['category', 'subcategory', 'bids'])->get();

    return response()->json(['products' => $auctions]);
}
    
    public function show($id)
    {
        // ID se auction ko dhoondhein
         $auction = Auction::findOrFail($id);
        $users = User::get();
        $categories = AuctionCategory::all();
        $subCategories = AuctionCategory::with('subcategories')->get();

        // Ek view ke saath data return karen
        return view('auction.create', compact('auction', 'users','subCategories', 'categories'));
    }
        public function edit(Auction $auction)
    {
        $users         = User::all();
        $categories    = AuctionCategory::whereNull('parent_id')
                             ->whereNull('sub_category_id')
                             ->get();
        $subCategories = AuctionCategory::with('subcategories')->get();

        return view('auction.create', compact(
            'auction','users','categories','subCategories'
        ));
    }

  public function update(Request $request, Auction $auction)
{
    $listType = $request->input('list_type', $auction->list_type ?? 'auction');
    $rules = [
        'title'             => ['required','string','min:2','max:100'],
        'category_id'       => ['required','integer','exists:auction_categories,id'],
        'sub_category_id'   => ['nullable','integer','exists:auction_categories,id'],
        'child_category_id' => ['nullable','integer','exists:auction_categories,id'],
        'description'       => ['required','string'],
        'list_type'         => ['required','in:auction,normal_list'],
    ];

    // Auction-specific rules
    if ($listType === 'auction') {
        $rules['start_date'] = ['required','date'];
        $rules['end_date'] = ['required','date','after_or_equal:start_date'];
        $rules['reserve_price'] = ['required','numeric'];
        $rules['minimum_bid'] = ['required','numeric'];
        $rules['product_year'] = ['required'];
        $rules['status'] = ['required'];
    }

    // Normal List-specific rules
    if ($listType === 'normal_list') {
        $rules['product_condition'] = ['required','in:new,old'];
        $rules['product_year'] = ['required'];
        $rules['minimum_bid'] = ['required','numeric']; // Price field
    }

    // New fields (optional by default)
    $rules += [
        'developer'            => ['nullable','string','max:255'],
        'location_url'         => ['nullable','max:1024'],
        'delivery_date'        => ['nullable','date'],
        'sale_starts'          => ['nullable','date'],
        'payment_plan'         => ['nullable','string'],
        'number_of_buildings'  => ['nullable','integer','min:0'],
        'government_fee'       => ['nullable','string'],
        'nearby_location'      => ['nullable','string'],
        'amenities'            => ['nullable','string'],
        'facilities'           => ['nullable','string'],
    ];

    $validated = $request->validate($rules);

    // Album update (optional)
    if ($request->hasFile('album')) {
        $albumFiles = $request->file('album');
        if (!is_array($albumFiles)) $albumFiles = [$albumFiles];
        $albumsArray = [];
        foreach ($albumFiles as $file) {
            $albumName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('/assets/images/auction/'), $albumName);
            $albumsArray[] = '/assets/images/auction/' . $albumName;
        }
        $validated['album'] = json_encode($albumsArray);
        if (!empty($albumsArray)) {
            $validated['image'] = $albumsArray[0];
        }
    }

    // Extra fields you set without validation earlier:
    $validated['featured_name']   = $request->input('featured_name');
    $validated['create_category'] = $request->input('create_category');
    $validated['list_type'] = $listType;
    $validated['product_condition'] = $request->input('product_condition');

    // For normal_list, set default values
    if ($listType === 'normal_list') {
        if (empty($validated['status'])) {
            $validated['status'] = 'active';
        }
        // Set reserve_price to minimum_bid value or keep existing if not provided
        if (empty($validated['reserve_price'])) {
            $validated['reserve_price'] = $validated['minimum_bid'] ?? $auction->reserve_price ?? 0;
        }
        // Set start_date and end_date to null if not provided
        if (empty($validated['start_date'])) {
            $validated['start_date'] = null;
        }
        if (empty($validated['end_date'])) {
            $validated['end_date'] = null;
        }
    }

    // NEW fields are already in $validated — just update:
    $auction->update($validated);

    return redirect()->route('auctions.index')->with('success', 'Auction updated successfully');
}

    
    public function destroy(Auction $auction)
    {
        $auction->delete();

        return redirect()->route('auctions.index')->with('success', 'Auction deleted successfully');
    }

    public function get_subcategories($id)
    {
        $categories = Subcategory::where('auction_category_id', $id)->get();

            $sub="";
            foreach($categories as $cat){

                $sub .= '<option value="'.$cat->id.'">'.$cat->name.'</option>';
            }
        return response()->json(['status'=>true,'message'=> $sub]);
    }

    public function get_products()
    {  
        $product = Auction::where('status','active')->withMax('bids', 'bid_amount')->latest()->get()->take(9);
        
    // Add owner data for each product
    foreach($product as $products){
        $user = User::find($products->user_id);
        $products->owner = [
            "name" => $user->name ?? '',
            "profile" => $user->profile_pic ?? ''
        ];
    }
    
        return response()->json(['product' => $product]);
    }

public function get_featured(){
    $products = Auction::where('featured_name', 'home_featured')
                      ->withMax('bids', 'bid_amount')
                      ->where("status", "active")
                      ->latest()
                      ->get();
    
    // Add owner data for each product
    foreach($products as $product){
        $user = User::find($product->user_id);
        $product->owner = [
            "name" => $user->name ?? '',
            "profile" => $user->profile_pic ?? ''
        ];
    }
    
    return response()->json(['product' => $products]);
}
public function get_featured_vehicle(){
    $product = Auction::where('featured_name', 'vehicle_featured')
                      ->where("status", "active")
                      ->latest()
                      ->get();
    return response()->json(['product' => $product]);
}
public function get_featured_service(){
    $product = Auction::where('featured_name', 'service_featured')
                      ->where("status", "active")
                      ->latest()
                      ->get();
    return response()->json(['product' => $product]);
}
public function get_featured_realstate(){
    $product = Auction::where('featured_name', 'realstate_featured')
                      ->where("status", "active")
                      ->latest()
                      ->get();
    return response()->json(['product' => $product]);
}
    public function get_vehicle(){
        $product = Auction::whereBetween('category_id', [190, 200]) ->orWhere('category_id', 214)->where("status","active")->latest()->get();
        
        return response()->json(['product' => $product]);
    }
    public function get_realestate(){
        $product = Auction::whereBetween('category_id', [207, 211]) ->orWhere('category_id', 216)->where("status","active")->latest()->get();
        return response()->json(['product' => $product]);
    }
    public function get_service(){
    $product = Auction::whereBetween('category_id', [201, 206]) ->orWhere('category_id', 215)
                ->where("status", "active")
                ->latest()
                ->get();
    return response()->json(['product' => $product]);
}

    // Latest Vehicles API - category_id = 311, latest 12
    public function get_latest_vehicles()
    {
        $products = Auction::where('category_id', 311)
            ->where('status', 'active')
            ->withMax('bids', 'bid_amount')
            ->latest()
            ->take(12)
            ->get();
        
        // Add owner data for each product
        foreach($products as $product){
            $user = User::find($product->user_id);
            $product->owner = [
                "name" => $user->name ?? '',
                "profile" => $user->profile_pic ?? ''
            ];
        }
        
        return response()->json(['product' => $products]);
    }

    // Latest Properties API - category_id = 222, latest 12
    public function get_latest_properties()
    {
        $products = Auction::where('category_id', 222)
            ->where('status', 'active')
            ->withMax('bids', 'bid_amount')
            ->latest()
            ->take(12)
            ->get();
        
        // Add owner data for each product
        foreach($products as $product){
            $user = User::find($product->user_id);
            $product->owner = [
                "name" => $user->name ?? '',
                "profile" => $user->profile_pic ?? ''
            ];
        }
        
        return response()->json(['product' => $products]);
    }

    // Latest Normal Lists API - list_type = 'normal_list', latest 12
    public function get_latest_normal_lists()
    {
        $products = Auction::where('list_type', 'normal_list')
            ->where('status', 'active')
            ->withMax('bids', 'bid_amount')
            ->latest()
            ->take(12)
            ->get();
        
        // Add owner data for each product
        foreach($products as $product){
            $user = User::find($product->user_id);
            $product->owner = [
                "name" => $user->name ?? '',
                "profile" => $user->profile_pic ?? ''
            ];
        }
        
        return response()->json(['product' => $products]);
    }

    // Latest Auctions API - list_type = 'auction' or null, latest 12
    public function get_latest_auctions()
    {
        $products = Auction::where(function($query) {
                $query->where('list_type', 'auction')
                      ->orWhereNull('list_type');
            })
            ->where('status', 'active')
            ->withMax('bids', 'bid_amount')
            ->latest()
            ->take(12)
            ->get();
        
        // Add owner data for each product
        foreach($products as $product){
            $user = User::find($product->user_id);
            $product->owner = [
                "name" => $user->name ?? '',
                "profile" => $user->profile_pic ?? ''
            ];
        }
        
        return response()->json(['product' => $products]);
    }
    
    public function products_views($id){
        try {
            // Find the product by ID
            $product = Auction::findOrFail($id);
            //dd($id);
            // Increment the views column
            $product->increment('views');

            return response()->json([
                'message' => 'View count updated successfully',
                'views' => $product->views
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to update view count',
                'error' => $e->getMessage()
            ], 500);
        }
    }

  public function products_details($slug){
    $id = Auction::where('slug', $slug)->value('id');
    
    $pro = Auction::find($id);
    // Eager load user relationship to get profile_pic
    $bids = Bid::where('auction_id', $id)->with('user')->latest()->get();
    $user = User::find(optional($pro)->user_id);

    $product['product'] = [$pro];
    $product['owner'][] = [
        "name"=>$user->name??'',
        "profile"=>$user->profile_pic??'',
    ];
    
    $product['bids'] = []; // Initialize bids array
    foreach($bids as $bid){
        $product['bids'][] = [
            "id" => $bid->id, // Add id for React key
            "userName" => $bid->user->name ?? 'Unknown',
            "userImage" => $bid->user->profile_pic ?? '',
            "date" => $bid->created_at->format('d M Y'),
            "amount" => $bid->bid_amount
        ];
    }

    // Get related auctions with owner data
    $relatedAuctions = Auction::where('id', '!=', $id)->where('status','active')->take(8)->get();
    
    $relatedItemsArray = [];
    foreach($relatedAuctions as $auction){
        $owner = User::find($auction->user_id);
        $relatedItemsArray[] = [
            'id' => $auction->id,
            'slug' => $auction->slug,
            'title' => $auction->title,
            'album' => $auction->album,
            'image' => $auction->image,
            'current_highest_bid' => $auction->current_highest_bid ?? $auction->minimum_bid,
            'minimum_bid' => $auction->minimum_bid,
            'start_date' => $auction->start_date,
            'end_date' => $auction->end_date,
            'owner' => [
                'name' => $owner->name ?? '',
                'profile' => $owner->profile_pic ?? '',
            ]
        ];
    }
    
    $product['relatedItems'][] = $relatedItemsArray;

    return response()->json(['product' => $product]);
}
     public function get_products_category($id){
            //dd($id);
            if (is_numeric($id)) {
            // If it's a number, fetch category by ID
            $category = AuctionCategory::find($id);
            } else {
                // If it's a string, fetch category by slug
            $cat_id = AuctionCategory::where('name',$id)->get()->pluck('id');
            }
            $cat_id = AuctionCategory::where('name',$id)->get()->pluck('id');
            $product = Auction::where('child_category_id',$cat_id)->latest()->get();
                        //dd($product);

            return response()->json(['product' => $product]);
        }

    public function get_countries(){
        $country = Country::all();
        return response()->json(['country' => $country]);
    }
    
    public function get_states_country_name($country_id){
        $country = Country::where("sortname", $country_id)->first();
        if(!$country){
            return response()->json(['state' => $state, 'success'=>false], 200);
        }
        $state = State::where('country_id',$country->id)->get();
        return response()->json(['state' => $state, 'success'=>true], 200);
    }
    public function get_states($country_id){
        $state = State::where('country_id',$country_id)->get();
        return response()->json(['state' => $state]);
    }

    public function get_cities_by_state_name($state_id){
        
        if(!$state_id){
            return response()->json(['city' => $city, 'success'=>false], 200);
        }
        
        $city = City::where('state_id',$state_id)->get();
        
        return response()->json(['city' => $city, 'success'=>true], 200);
    }
 
    public function get_cities($state_id){
        $city = City::where('state_id',$state_id)->get();
        return response()->json(['city' => $city]);
    }
 
    public function bid(Request $request, $auctionId)
    {
        $user = auth()->user();
        $auction = Auction::findOrFail($auctionId);
    
        // Logic to handle the bid
    
        // Send notification to the previous highest bidder
        $oneSignalService = new OneSignalService();
        $oneSignalService->sendNotification($previousHighestBidder->oneSignalPlayerId, 'You have been outbid.');
    
        // Send notification to the current highest bidder (you, the user who just won)
        if ($user->id == $auction->current_bidder_id) {
            $oneSignalService->sendNotification($user->oneSignalPlayerId, 'Congratulations, you won the auction!');
        }
    
        return response()->json(['message' => 'Bid placed successfully']);
    }
    
    public function canBid(Auction $auction)
    {
    // If current time is past end_date or status != active
    return now()->isBefore($auction->end_date) && $auction->status === 'active';
}   
   public function api_store(Request $request)
{
    // 1) Get list_type from request
    $listType = $request->input('list_type', 'auction');
    
    // 2) Base validation rules
    $rules = [
        'title'             => 'required|min:2|max:100',
        'category_id'       => 'required|integer|exists:auction_categories,id',
        'sub_category_id'   => 'nullable|integer|exists:auction_categories,id',
        'child_category_id' => 'nullable|integer|exists:auction_categories,id',
        'description'       => 'required',
        'list_type'         => 'required|in:auction,normal_list',
        'product_year'      => 'required',
        'product_location'  => 'nullable',
        // Add new property fields
        'developer'         => 'nullable|string|max:255',
        'location_url'      => 'nullable|max:1024',
        'delivery_date'     => 'nullable|date',
        'sale_starts'       => 'nullable|date',
        'payment_plan'      => 'nullable|string',
        'number_of_buildings' => 'nullable|integer|min:0',
        'government_fee'    => 'nullable|string',
        'nearby_location'   => 'nullable|string',
        'amenities'         => 'nullable|string',
        'facilities'        => 'nullable|string',
    ];

    // Auction-specific rules
    if ($listType === 'auction') {
        $rules['start_date'] = 'required|date';
        $rules['end_date'] = 'required|date|after_or_equal:start_date';
        $rules['reserve_price'] = 'required|numeric';
        $rules['minimum_bid'] = 'required|numeric';
    }

    // Normal List-specific rules
    if ($listType === 'normal_list') {
        $rules['product_condition'] = 'required|in:new,old';
        $rules['minimum_bid'] = 'required|numeric'; // Price field
        $rules['start_date'] = 'nullable|date';
        $rules['end_date'] = 'nullable|date';
        $rules['reserve_price'] = 'nullable|numeric';
    }

    // Custom error messages
    $messages = [
        'title.required'             => 'Please enter a title for your listing.',
        'title.min'                  => 'Title must be at least :min characters.',
        'title.max'                  => 'Title may not exceed :max characters.',
        'category_id.required'       => 'Please select a category.',
        'category_id.integer'        => 'Category must be a valid selection.',
        'category_id.exists'         => 'Selected category does not exist.',
        'start_date.required'        => 'Please select a start date.',
        'start_date.date'            => 'Start date must be a valid date.',
        'end_date.required'          => 'Please select an end date.',
        'end_date.date'              => 'End date must be a valid date.',
        'end_date.after_or_equal'    => 'End date must be on or after the start date.',
        'reserve_price.required'     => 'Please set a reserve price.',
        'reserve_price.numeric'      => 'Reserve price must be a number.',
        'minimum_bid.required'       => 'Please enter the minimum bid amount.',
        'minimum_bid.numeric'        => 'Minimum bid must be a number.',
        'description.required'       => 'Please provide a description of your product.',
        'product_year.required'      => 'Please specify the products year.',
        'product_condition.required' => 'Please select product condition (new or old).',
        'product_condition.in'        => 'Product condition must be either new or old.',
        'list_type.required'         => 'Please select a list type.',
        'list_type.in'               => 'List type must be either auction or normal_list.',
        // Add custom error messages for new fields
        'location_url.url'           => 'Please enter a valid URL.',
        'number_of_buildings.integer' => 'Number of buildings must be a whole number.',
        'number_of_buildings.min'    => 'Number of buildings cannot be negative.',
    ];

    $validatedData = $request->validate($rules, $messages);

    // ------------------------------------------------------------
    // 2) Verification gate: allow if EITHER Individual OR Corporate is approved
    // ------------------------------------------------------------
    $userId = auth()->id();

    $individual = IndividualVerification::where('user_id', $userId)->first();
    $corporate  = CorporateVerification::where('user_id', $userId)->first();

    // helper closures
    $isApproved = function ($rec) {
        if (!$rec) return false;
        return in_array(strtolower($rec->status), ['approved', 'verified'], true);
    };
    $isPending = function ($rec) {
        if (!$rec) return false;
        return in_array(strtolower($rec->status), ['pending', 'not_verified', 'submitted'], true);
    };
    $isRejected = function ($rec) {
        if (!$rec) return false;
        return in_array(strtolower($rec->status), ['rejected', 'declined'], true);
    };

    $verificationUrl = 'https://xpertbid.com/account?tab=identity_verification';

    // Case A: neither record exists
    if (!$individual && !$corporate) {
		
        return response()->json([
            'success'       => false,
            'is_verified'   => false,
            'message'       => 'You need to complete verification before creating a listing. Please verify your identity (individual or corporate).',
            'verify_url'    => $verificationUrl,
            'which'         => 'none',
        ], 403);
    }

    // Case B: approved if either side approved
    if ($isApproved($individual) || $isApproved($corporate)) {
        // pass
    } else {
        // Not approved anywhere — tell most relevant state
        if ($isPending($individual) || $isPending($corporate)) {
			
            return response()->json([
                'success'       => false,
                'is_verified'   => false,
                'message'       => 'Your verification has been submitted and is currently pending review.',
                'verify_url'    => $verificationUrl,
                'which'         => $isPending($corporate) ? 'corporate' : 'individual',
            ], 403);
        }

        if ($isRejected($individual) || $isRejected($corporate)) {
            return response()->json([
                'success'       => false,
                'is_verified'   => false,
                'message'       => 'Your verification was rejected. Please resubmit the required documents.',
                'verify_url'    => $verificationUrl,
                'which'         => $isRejected($corporate) ? 'corporate' : 'individual',
            ], 403);
        }

        // Fallback: some unknown status
        return response()->json([
            'success'       => false,
            'is_verified'   => false,
            'message'       => 'Verification is not complete. Please complete verification to proceed.',
            'verify_url'    => $verificationUrl,
            'which'         => ($individual ? 'individual' : 'corporate'),
            'debug_status'  => [
                'individual' => $individual->status ?? null,
                'corporate'  => $corporate->status ?? null,
            ],
        ], 403);
    }

    // ------------------------------------------------------------
    // 3) Handle album images and videos (updated for video support)
    // ------------------------------------------------------------
    $albumsArray = [];
    if ($request->hasFile('album')) {
        $albumFiles = $request->file('album');
        if (!is_array($albumFiles)) {
            $albumFiles = [$albumFiles];
        }
        foreach ($albumFiles as $file) {
            $albumName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            
            // Determine if it's a video or image
            if ($file->getMimeType() === 'video/mp4') {
                $file->move(public_path('/assets/videos/auction/'), $albumName);
                $albumsArray[] = '/assets/videos/auction/' . $albumName;
            } else {
                $file->move(public_path('/assets/images/auction/'), $albumName);
                $albumsArray[] = '/assets/images/auction/' . $albumName;
            }
        }
    }

    // ------------------------------------------------------------
    // 4) Create auction with all fields including new property fields
    // ------------------------------------------------------------
    $auctionData = array_merge($validatedData, [
        'image'           => count($albumsArray) > 0 ? $albumsArray[0] : null,  // cover image
        'album'           => json_encode($albumsArray),
        'user_id'         => auth()->user()->id,
        'status'          => 'inactive', // default status
        'create_category' => $request->input('create_category'),
        'list_type'       => $listType,
        // The new property fields and category_id are already included in $validatedData
        // They will be automatically added to the auction record
    ]);

    // For normal_list, set default values
    if ($listType === 'normal_list') {
        // Status remains 'inactive' for normal_list (as set above)
        // Set reserve_price to minimum_bid value or 0 if not provided
        if (empty($auctionData['reserve_price']) || $auctionData['reserve_price'] === null) {
            $auctionData['reserve_price'] = !empty($auctionData['minimum_bid']) ? $auctionData['minimum_bid'] : 0;
        }
        // Set start_date and end_date to null
        $auctionData['start_date'] = null;
        $auctionData['end_date'] = null;
    }

    $auction = Auction::create($auctionData);

    // ------------------------------------------------------------
    // 5) Send email to user (try/catch)
    // ------------------------------------------------------------
    $user        = auth()->user();
    $firstName   = $user->name;
    $listingTitle= $auction->title;
    // Only parse end_date if it exists (for normal_list it might be null)
    $auctionEnds = $auction->end_date ? \Carbon\Carbon::parse($auction->end_date)->toDayDateTimeString() : 'N/A';

    try {
        Mail::to($user->email)->send(
            new \App\Mail\NewListingNotification($firstName, $listingTitle, $auctionEnds)
        );
       Mail::to(env('ADMIN_EMAIL'))->send(
            new \App\Mail\NewListingNotification($firstName, $listingTitle, $auctionEnds)
        );
    } catch (\Exception $e) {
        \Log::error('Failed to send NewListingNotification: ' . $e->getMessage());
    }

    return response()->json([
        'status'     => 'success',
        'message'    => 'Auction created successfully',
        'auction_id' => $auction->id,
        'auction'    => $auction,
    ], 201);
}

public function api_update(Request $request, $id)
{
    // 1) Validate
    $validatedData = $request->validate([
        'title'               => 'required|min:2|max:100',
        'category_id'         => 'required',
        'start_date'          => 'required|date',
        'end_date'            => 'required|date|after_or_equal:start_date',
        'reserve_price'       => 'required|numeric',
        'minimum_bid'         => 'required|numeric',
        'description'         => 'required',
        'product_year'        => 'required',
        'product_location'    => 'nullable',
        'sub_category_id'     => 'nullable',
        'child_category_id'   => 'nullable',
        // New property fields
        'developer'           => 'nullable|string|max:255',
        'location_url'        => 'nullable|max:1024',
        'delivery_date'       => 'nullable|date',
        'sale_starts'         => 'nullable|date',
        'payment_plan'        => 'nullable|string',
        'number_of_buildings' => 'nullable|integer|min:0',
        'government_fee'      => 'nullable|string',
        'nearby_location'     => 'nullable|string',
        'amenities'           => 'nullable|string',
        'facilities'          => 'nullable|string',
    ]);

    // 2) Load auction
    $auction = Auction::findOrFail($id);
    $oldStatus = (string) ($auction->status ?? ''); // capture old status early

    // 3) Unified verification gate (Individual OR Corporate)
    $userId     = auth()->id();
    $individual = IndividualVerification::where('user_id', $userId)->first();
    $corporate  = CorporateVerification::where('user_id', $userId)->first();

    $norm = function ($rec) { return strtolower($rec->status ?? ''); };
    $isApproved = function ($rec) use ($norm) {
        if (!$rec) return false;
        return in_array($norm($rec), ['approved','verified'], true);
    };
    $isPending = function ($rec) use ($norm) {
        if (!$rec) return false;
        return in_array($norm($rec), ['pending','not_verified','submitted'], true);
    };
    $isRejected = function ($rec) use ($norm) {
        if (!$rec) return false;
        return in_array($norm($rec), ['rejected','declined'], true);
    };

    $verificationUrl = 'https://xpertbid.com/account?tab=identity_verification';

    if (!$individual && !$corporate) {
        return response()->json([
            'success'=>false,'is_verified'=>false,
            'message'=>'You need to complete verification before updating a listing. Please verify your identity (individual or corporate).',
            'verify_url'=>$verificationUrl,'which'=>'none',
        ], 403);
    }

    if (!($isApproved($individual) || $isApproved($corporate))) {
        if ($isPending($individual) || $isPending($corporate)) {
            return response()->json([
                'success'=>false,'is_verified'=>false,
                'message'=>'Your verification has been submitted and is currently pending review.',
                'verify_url'=>$verificationUrl,
                'which'=>$isPending($corporate)?'corporate':'individual',
            ], 403);
        }
        if ($isRejected($individual) || $isRejected($corporate)) {
            return response()->json([
                'success'=>false,'is_verified'=>false,
                'message'=>'Your verification was rejected. Please resubmit the required documents.',
                'verify_url'=>$verificationUrl,
                'which'=>$isRejected($corporate)?'corporate':'individual',
            ], 403);
        }
        return response()->json([
            'success'=>false,'is_verified'=>false,
            'message'=>'Verification is not complete. Please complete verification to proceed.',
            'verify_url'=>$verificationUrl,
            'which'=>($individual ? 'individual' : 'corporate'),
            'debug_status'=>[
                'individual'=>$individual->status ?? null,
                'corporate'=>$corporate->status ?? null,
            ],
        ], 403);
    }

    // 4) Album handling
    $newAlbum = [];
    $dest = public_path('/assets/images/auction/');
    if (!is_dir($dest)) @mkdir($dest, 0755, true);

    if ($request->hasFile('album')) {
        $albumFiles = $request->file('album');
        if (!is_array($albumFiles)) $albumFiles = [$albumFiles];

        foreach ($albumFiles as $file) {
            if (!$file->isValid()) continue;
            $name = time().'_'.uniqid().'.'.$file->getClientOriginalExtension();
            $file->move($dest, $name);
            $newAlbum[] = '/assets/images/auction/'.$name;
        }
    }

    // Current album from DB → array
    $currentAlbumRaw = $auction->album;
    $currentAlbumArr = [];
    if (is_array($currentAlbumRaw)) {
        $currentAlbumArr = $currentAlbumRaw;
    } elseif (is_string($currentAlbumRaw)) {
        $decoded = json_decode($currentAlbumRaw, true);
        $currentAlbumArr = is_array($decoded) ? $decoded : [];
    }

    // Decide album & image values
    if (count($newAlbum) > 0) {
        // New uploads replace album completely
        $albumValue = json_encode($newAlbum);
        $imageValue = $newAlbum[0];
    } else {
        // Keep old album as-is
        $albumValue = json_encode($currentAlbumArr ?: ($auction->image ? [$auction->image] : []));
        $imageValue = $auction->image;
    }

    // ✅ Respect cover_from_old when NO new upload is provided
    if (!$request->hasFile('album') && $request->filled('cover_from_old')) {
        $cover = $request->input('cover_from_old');

        // normalize if full http(s) URL given
        if (strpos($cover, 'http://') === 0 || strpos($cover, 'https://') === 0) {
            $cover = parse_url($cover, PHP_URL_PATH) ?: $cover;
        }

        // If cover is present in old album, or you trust frontend, set it
        $albumDecoded = json_decode($albumValue, true) ?: [];
        if (in_array($cover, $albumDecoded, true)) {
            $imageValue = $cover;
        } else {
            $imageValue = $cover;
        }
    }

    // 5) Vehicle Verification Update (conditional)
    if ($request->filled('vehicle_make_model') && $request->filled('year_of_manufacture') && $request->filled('chassis_vin')) {
        $vehicle = \App\Models\VehicleVerification::where('auction_id', $auction->id)->first();

        $vehicleData = [
            'user_id'             => auth()->id(),
            'auction_id'          => $auction->id,
            'vehicle_make_model'  => $request->input('vehicle_make_model'),
            'year_of_manufacture' => $request->input('year_of_manufacture'),
            'chassis_vin'         => $request->input('chassis_vin'),
            'status'              => 'not_verified',
        ];

        $publicPaths  = [];
        $vDest = public_path('assets/images/vehicle_verifications');
        if (!is_dir($vDest)) @mkdir($vDest, 0755, true);

        if ($request->hasFile('vehicle_documents')) {
            foreach ($request->file('vehicle_documents') as $file) {
                if (!$file->isValid()) continue;
                $filename = time().'_'.uniqid().'.'.$file->getClientOriginalExtension();
                $file->move($vDest, $filename);
                $publicPaths[] = "assets/images/vehicle_verifications/{$filename}";
            }
            $vehicleData['vehicle_documents'] = $publicPaths;
        }

        if ($vehicle && !$request->hasFile('vehicle_documents')) {
            $vehicleData['vehicle_documents'] = $vehicle->vehicle_documents;
        }

        if ($vehicle) $vehicle->update($vehicleData);
        else {
            $vehicleData['vehicle_documents'] = $publicPaths;
            \App\Models\VehicleVerification::create($vehicleData);
        }
    }

    // 6) Property Verification Update (conditional)
    if ($request->filled('property_type') && $request->filled('property_address') && $request->filled('title_deed_number')) {
        $property = \App\Models\PropertyVerification::where('auction_id', $auction->id)->first();

        $propertyData = [
            'user_id'           => auth()->id(),
            'auction_id'        => $auction->id,
            'property_type'     => $request->input('property_type'),
            'property_address'  => $request->input('property_address'),
            'title_deed_number' => $request->input('title_deed_number'),
            'status'            => 'not_verified',
        ];

        $paths = [];
        $pDest = public_path('assets/images/property_verifications');
        if (!is_dir($pDest)) @mkdir($pDest, 0755, true);

        if ($request->hasFile('property_documents')) {
            foreach ($request->file('property_documents') as $file) {
                if (!$file->isValid()) continue;
                $filename = uniqid().'_'.time().'.'.$file->getClientOriginalExtension();
                $file->move($pDest, $filename);
                $paths[] = 'assets/images/property_verifications/'.$filename;
            }
            $propertyData['property_documents'] = $paths;
        }

        if ($property && !$request->hasFile('property_documents')) {
            $propertyData['property_documents'] = $property->property_documents;
        }

        if ($property) $property->update($propertyData);
        else {
            $propertyData['property_documents'] = $paths;
            \App\Models\PropertyVerification::create($propertyData);
        }
    }

    // 7) Update auction (mark as resubmit)
    $auctionData = array_merge($validatedData, [
        'image'           => $imageValue,
        'album'           => $albumValue,
        'create_category' => $request->input('create_category'),
        'status'          => 'resubmit', // business rule
    ]);

    $auction->update($auctionData);

    // 8) Email: send only if the status changed (e.g., to 'resubmit')
    $newStatus = (string) ($auction->status ?? '');
    $emailed   = false;
    $mailError = null;

    if ($oldStatus !== $newStatus) {
        try {
            // Figure out the best recipient email
            $recipient = optional($auction->user)->email
                ?? optional(auth()->user())->email
                ?? null;

            if ($recipient) {
                Mail::to($recipient)
                    ->bcc(env('ADMIN_EMAIL')) // optional admin copy
                    ->send(new AuctionStatusUpdated($auction, $oldStatus, $newStatus));
                $emailed = true;
            }
        } catch (\Throwable $e) {
            // Don't break the API if mail fails; include a flag for client logs
            $mailError = app()->hasDebugModeEnabled() ? $e->getMessage() : 'mail_failed';
        }
    }

    return response()->json([
        'status'   => 'success',
        'message'  => 'Auction updated successfully',
        'auction'  => $auction,
        'email'    => [
            'attempted' => ($oldStatus !== $newStatus),
            'sent'      => $emailed,
            'error'     => $mailError,
        ],
    ]);
}




public function cancel($id)
{
    $listing = Auction::findOrFail($id);

    // (Optional) authorization — uncomment if you have policies
    // $this->authorize('update', $listing);

    $oldStatus = (string) ($listing->status ?? '');
    $newStatus = 'cancelled';

    // No-op if already cancelled
    if ($oldStatus === $newStatus) {
        return response()->json([
            'message' => 'Listing is already cancelled.',
            'listing' => $listing,
            'email'   => ['attempted' => false, 'sent' => false, 'error' => null],
        ]);
    }

    // Update status
    $listing->status = $newStatus;
    $listing->save();

    // Email notify owner + admin (safe fail)
    $emailed   = false;
    $mailError = null;

    try {
        $recipient = optional($listing->user)->email
            ?? optional(auth()->user())->email
            ?? null;

        if ($recipient) {
            Mail::to($recipient)
                ->bcc(env('ADMIN_EMAIL')) // optional admin copy
                ->send(new AuctionStatusUpdated($listing, $oldStatus, $newStatus));
            // ->queue(new AuctionStatusUpdated($listing, $oldStatus, $newStatus)); // use queue if desired
            $emailed = true;
        }
    } catch (\Throwable $e) {
        $mailError = app()->hasDebugModeEnabled() ? $e->getMessage() : 'mail_failed';
    }

    return response()->json([
        'message' => 'Listing cancelled successfully',
        'listing' => $listing,
        'email'   => [
            'attempted' => true,
            'sent'      => $emailed,
            'error'     => $mailError,
        ],
    ]);
}

public function api_show($id)
{
    $auction = Auction::with([
        'property_verification',
        'vehicle_verification'
    ])->find($id);

    if (!$auction) {
        return response()->json(['message' => 'Auction not found'], 404);
    }

    return response()->json(['auction' => $auction]);
}

  public function listings()
{
    $user = Auth::user();

    $auctions = Auction::where('user_id', $user->id)
        ->with('bids') // Make sure to eager load bids
        ->get()
        ->map(function ($auction) {
            $highestBid = $auction->bids->max('bid_amount'); // Highest bid from related bids
            return [
                'id' => $auction->id,
                'slug' => $auction->slug,
                'title' => $auction->title,
                'album' => $auction->album,
                'start_date' => $auction->start_date,
                'end_date' => $auction->end_date,
                'featured_name'=> $auction->featured_name,
                'status'=> $auction->status,
                'currentBid' => $highestBid,
                // ...other fields if needed
            ];
        });

    return response()->json(['auction' => $auctions]);
}

    
   public function dashboard()
{
    $user = Auth::user();
    
    // Auctions for the user
    $auctions = Auction::where('user_id', $user->id)->where('status','active')->get();
    
    // Bid count for the user
    $bidCount = Bid::where('user_id', $user->id)->count();
    
    // Wallet balance for the user
    // Yahan assume kar rahe hain ke aapke paas Wallet model aur users table mein wallet data hai.
    // Agar wallet ka table ya model nahin hai, to uske hisaab se code adjust karein.
    $walletAmount = Wallet::where('user_id', $user->id)->value('balance') ?? 0;

    return response()->json([
        'auction' => $auctions,
        'bid'     => $bidCount,
        'wallet'  => $walletAmount,
    ]);
}

    public function getAuctionsByStatus(Request $request)
    {
        $user = $request->user(); // Authenticated user
        $status = $request->query('status');

        $auctions = [];

        switch ($status) {
            case 'won':
                $auctions = Auction::where('winner_id', $user->id)->get();
                break;

            case 'lost':
                $auctions = Auction::whereHas('bids', function ($query) use ($user) {
                    $query->where('user_id', $user->id);
                })
                ->where('winner_id', '!=', $user->id)
                ->get();
                break;

            case 'active':
                $auctions = Auction::whereHas('bids', function ($query) use ($user) {
                    $query->where('user_id', $user->id);
                })
                ->whereDoesntHave('bids', function ($query) {
                    $query->whereRaw('bids.bid_amount > (SELECT MAX(bids.bid_amount) FROM bids WHERE bids.auction_id = auctions.id)');
                })
                ->get();
                break;

            default:
                return response()->json(['error' => 'Invalid status'], 400);
    }

    return response()->json([
        'status' => $status,
        'auctions' => $auctions,
    ]);
}

    public function search(Request $request)
    {
        $query = $request->input('query');

        if (!$query) {
            return response()->json(['auctions' => []]);
        }

        $auctions = Auction::where('title', 'like', "%{$query}%")
            ->orWhere('description', 'like', "%{$query}%")
            ->limit(10)
            ->get(['id', 'title','slug']);

        return response()->json(['auctions' => $auctions]);
    }
//new
 public function finalizeAuction($auctionId)
{
    $auction = Auction::findOrFail($auctionId);

    // Ensure the auction has ended before finalizing
    if ($auction->end_date < now()) {
        // Get the highest bid (winner)
        $highestBid = $auction->bids()->orderByDesc('bid_amount')->first();
        if (!$highestBid) {
            return response()->json(['error' => 'No bids found for this auction.'], 400);
        }
        $winner = $highestBid->user;

        // Update the auction status and record the winner
        $auction->update([
            'status'    => 'completed',
            'winner_id' => $winner->id,
        ]);

        // Send Auction Won Notification to the winner
        $firstName = $winner->name; // Winner's first name
        $listingTitle = $auction->title; // Adjust if your Auction model uses a different field for the title
        $winningBidAmount = $highestBid->bid_amount;
        // Format the auction end date as desired, e.g., using Carbon formatting
        $auctionEnded = \Carbon\Carbon::parse($auction->end_date)->toDayDateTimeString();
        // Create a payment link to route where winner can complete their payment; adjust route as needed
        $completePaymentLink = route('complete.payment', ['auction' => $auction->id, 'user' => $winner->id]);

        Mail::to($winner->email)
            ->send(new AuctionWonNotification($firstName, $listingTitle, $winningBidAmount, $auctionEnded, $completePaymentLink));

        // Retrieve all bids except the winning bid
        $losingBids = $auction->bids()->where('user_id', '!=', $winner->id)->get();
        // Get unique losing users (in case a user bid multiple times)
        $losingUsers = $losingBids->pluck('user')->unique('id');
        // Define your dashboard link (update with your route or URL)
        $dashboardLink = route('myDashboard');

        // Send Auction Lost Notification email to each losing bidder
        foreach ($losingUsers as $loser) {
            // Retrieve the highest bid amount the user placed for this auction
            $userBidAmount = $losingBids->where('user_id', $loser->id)->max('bid_amount');

            Mail::to($loser->email)
                ->send(new \App\Mail\AuctionLostNotification($loser->name, $auction->title, $userBidAmount, $dashboardLink));
        }

        return response()->json(['message' => 'Auction completed and notifications sent.']);
    }

    return response()->json(['error' => 'Auction has not ended yet.'], 400);
}
public function filtered(Request $request)
{
    $q = Auction::query()->where('status', 'active');;

    // category filters
    if ($request->filled('category') && $request->input('category') != 'all') {
      $categorySlug = $request->input('category');
      $categoryId = AuctionCategory::where('slug', $categorySlug)->first();
      $q->where(function($subQuery) use ($categoryId) {
          $subQuery->where('category_id', $categoryId->id)
                   ->orWhere('sub_category_id', $categoryId->id)
                   ->orWhere('child_category_id', $categoryId->id);
      });
    }

    // NEW: brands filter (matches first word - partial match)
    if ($request->filled('brands')) {
        $brandsString = $request->input('brands');
        $brands = explode(',', $brandsString);
        if (!empty($brands)) {
            $q->where(function($query) use ($brands) {
                foreach ($brands as $brand) {
                    $query->orWhere('developer', 'LIKE', trim($brand) . '%');
                }
            });
        }
    }

    // status[] filter (array or comma-separated)
    $statuses = $request->input('status', []);
    $now      = Carbon::now();

    if (!in_array('Live Auctions', $statuses)) {
        $q->where('status', 'active');
    }

    if (in_array('Ending Soon', $statuses)) {
        $q->whereBetween('end_date', [$now, $now->copy()->addDay()]);
    }

    if (in_array('Recent Listings', $statuses)) {
        $q->whereBetween('start_date', [$now->copy()->subDay(), $now]);
    }

    // price range
    if ($request->filled('priceMin')) {
        $q->where('reserve_price', '>=', $request->priceMin);
    }
    if ($request->filled('priceMax')) {
        $q->where('reserve_price', '<=', $request->priceMax);
    }

    // pagination
    $perPage = $request->input('perPage', 8);
    $page    = $request->input('page', 1);
    
    $paginator = $q->withMax('bids', 'bid_amount')
                   ->orderBy('created_at', 'desc')
                   ->paginate($perPage, ['*'], 'page', $page);
    
    // ✅ Add owner data to each item
    $items = $paginator->items();
    foreach ($items as $item) {
        $user = User::find($item->user_id);
        $item->owner = [
            "name" => $user->name ?? '',
            "profile" => $user->profile_pic ?? ''
        ];
    }

    return response()->json([
        'items'       => $items,
        'currentPage' => $paginator->currentPage(),
        'perPage'     => $paginator->perPage(),
        'totalItems'  => $paginator->total(),
        'totalPages'  => $paginator->lastPage(),
    ]);
}

//new
}
