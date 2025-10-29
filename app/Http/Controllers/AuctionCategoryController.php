<?php
namespace App\Http\Controllers;

use App\Models\AuctionCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Auction;

class AuctionCategoryController extends Controller
{
    // Display categories
    public function index()
    {
        $categories = AuctionCategory::with('subCategories.childCategories')
            ->whereNull('parent_id')
            ->whereNull('sub_category_id')
            ->get();

        // now pass it to the view
        return view('auction_categories.index', compact('categories'));
    }

    // Show create form
    public function create()
{
    $parents       = AuctionCategory::whereNull('parent_id')
                      ->whereNull('sub_category_id')
                      ->get();
    $subCategories = collect();            // no subs yet
    return view('auction_categories.create', compact('parents','subCategories'));
}

    // Store category with an image
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:auction_categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Image validation
        ]);
        //dd($request);
        // Handle image upload
        $imagePath = null;
        if ($request->hasFile('image')) {
                $file = $request->file('image'); // Retrieve the file from the request

            //$imagePath = $request->file('image')->store('category_images', 'public');
            $albumName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('/assets/images/category_images/'), $albumName);
            $imagePath = '/assets/images/category_images/' . $albumName;
        }
        
        AuctionCategory::create([
            'name' => $request->name,
            'parent_id' => $request->parent_id,
            'sub_category_id' => $request->sub_category_id,
            'image' => $imagePath,
        ]);
        //dd($request->sub_category_id);

        return redirect()->route('auction_categories.index')->with('success', 'Category added successfully!');
    }

    // Show edit form
    public function edit($id)
{
    $category      = AuctionCategory::findOrFail($id);
    $parents       = AuctionCategory::whereNull('parent_id')
                      ->whereNull('sub_category_id')
                      ->get();
    $subCategories = $category->parent_id
        ? AuctionCategory::where('parent_id', $category->parent_id)
            ->whereNull('sub_category_id')
            ->get()
        : collect();

    return view('auction_categories.create', compact('category','parents','subCategories'));
}


    public function show($id)
{
    // category ke saath uske sub-categories bhi load karo
    $category = AuctionCategory::with('childrenRecursive')->findOrFail($id);

    // ek dedicated Blade view banani padegi: resources/views/auction_categories/show.blade.php
    return view('auction_categories.show', compact('category'));
}
	public function getSubCategoriess($parentId)
    {
        $subcategories = AuctionCategory::where('parent_id', $parentId)->get(['id','name','slug']);
        return response()->json(compact('subcategories'));
    }

    public function getChildCategoriess($subId)
    {
        $childcategories = AuctionCategory::where('parent_id', $subId)->get(['id','name','slug']);
        return response()->json(compact('childcategories'));
    }
    
    // Update category with an image
  public function update(Request $request, $id)
    {
    $category = AuctionCategory::findOrFail($id);

    $request->validate([
      'name'      => 'required|string|max:255',
      'parent_id' => 'nullable|exists:auction_categories,id',
      'image'     => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    // If a new image was uploaded…
    if ($request->hasFile('image')) {
        // 1) grab the uploaded file
        $file = $request->file('image');

        // 2) delete the old image from public/ if it exists
        if ($category->image && file_exists(public_path($category->image))) {
            unlink(public_path($category->image));
        }

        // 3) build a unique filename and move it
        $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('assets/images/category_images'), $filename);

        // 4) store the new relative path
        $category->image = 'assets/images/category_images/' . $filename;
    }

    // update the other fields
    $category->name      = $request->input('name');
    $category->parent_id = $request->input('parent_id');
    $category->save();

    return redirect()
        ->route('auction_categories.index')
        ->with('success', 'Category updated successfully!');
}

   
    // Delete category and its image
    public function destroy($id)
    {
        $category = AuctionCategory::findOrFail($id);

        if ($category->image) {
            Storage::disk('public')->delete($category->image);
        }

        $category->delete();

        return redirect()->route('auction_categories.index')->with('success', 'Category deleted successfully!');
    }
    
     public function getSubcategories($parentId)
      {
          $subs = AuctionCategory::where('parent_id', $parentId)
                 ->whereNull('sub_category_id')
                 ->get(['id','name','slug']);
          return response()->json(['subcategories' => $subs]);
      }
    
public function get_category()
{
    $priority = [222, 311];

    $categories = AuctionCategory::query()
        ->whereNull('parent_id')
        ->whereNull('sub_category_id')

        // Sirf woh categories jinke paas kam-az-kam 1 ACTIVE auction ho
        ->whereHas('auctions', function ($q) {
            $q->where('status', 'active');
        })

        // ✅ Guaranteed count via subquery (no withCount surprises)
        ->addSelect([
            'auction_categories.*',
            'active_auctions_count' => Auction::selectRaw('COUNT(*)')
                ->whereColumn('auctions.category_id', 'auction_categories.id')
                ->where('status', 'active')
        ])
        ->get();

    // Custom order: 222, 311, then the rest
    $ordered = $categories
        ->sortBy(function ($cat) use ($priority) {
            $pos = array_search($cat->id, $priority, true);
            return $pos === false ? PHP_INT_MAX : $pos;
        })
        ->values();

    return response()->json([
        'categories' => $ordered
    ]);
}
public function get_category_sell()
{
    // 1) Pehle sab root categories laa lo,
    //    aur sirf active auctions ka hi count nikaalo
    $categories = AuctionCategory::whereNull('parent_id')
        ->whereNull('sub_category_id')
        ->withCount('auctions')
        ->get();

    // 2) Custom order: id 222, phir 311, baaki sab baad mein
    $ordered = $categories->sortBy(function($cat) {
        $priority = [222, 311];
        $pos = array_search($cat->id, $priority);
        return $pos === false ? PHP_INT_MAX : $pos;
    })->values(); // re-index karne ke liye

    // 3) JSON response
    return response()->json([
        'categories' => $ordered
    ]);
}

    
   public function getChildern($id)
    {	
        // same logic as before…
        if (is_numeric($id)) {
            $category = AuctionCategory::find($id);
        } else {
            $category = AuctionCategory::where('name', $id)->first();
        }
        if (!$category) {
            return response()->json(['error'=>'Category not found'],404);
        }
        $subs = AuctionCategory::where('sub_category_id', $category->id)->get();
        return response()->json(['subcategories'=>$subs]);
    }
  
public function all_categories()
{
    // Change these if your priority changes
    // 222 first, then 311, then by id ASC
    $categories = AuctionCategory::query()
        ->whereNull('parent_id')
        ->whereNull('sub_category_id')

        // ✅ Include ONLY roots that have active items at ANY depth (root / sub / child)
        ->where(function ($q) {
            $q->whereHas('auctions', function ($a) {
                $a->where('status', 'active'); // adjust column if needed
            })
            ->orWhereHas('subCategories.auctions', function ($a) {
                $a->where('status', 'active');
            })
            ->orWhereHas('subCategories.childCategories.auctions', function ($a) {
                $a->where('status', 'active');
            });
        })

        // ✅ Eager load ONLY subcategories that have active items (self or children)
        ->with([
            'subCategories' => function ($q) {
                $q->where(function ($qq) {
                    $qq->whereHas('auctions', function ($a) {
                        $a->where('status', 'active');
                    })
                    ->orWhereHas('childCategories.auctions', function ($a) {
                        $a->where('status', 'active');
                    });
                })
                // ✅ Eager load ONLY child categories that have active items
                ->with(['childCategories' => function ($cq) {
                    $cq->whereHas('auctions', function ($a) {
                        $a->where('status', 'active');
                    });
                }]);
            },
        ])

        // ✅ Priority order: 222, 311, then id ASC
        ->orderByRaw("FIELD(id, 222, 311) DESC")
        ->orderBy('id')
        ->get();

    return response()->json(['category' => $categories]);
}




}
