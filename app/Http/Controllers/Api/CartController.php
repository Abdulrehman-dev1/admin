<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Auction;
use App\Models\ProductVariation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{
    /**
     * Get user's cart items
     */
    public function index(Request $request)
    {
        $user = $request->user();

        $cartItems = Cart::where('user_id', $user->id)
            ->with([
                'auction' => function ($query) {
                    $query->select('id', 'title', 'slug', 'image', 'minimum_bid', 'buy_now_price', 'is_buynow', 'list_type', 'status', 'description');
                }
            ])
            // Eager load variation (since we don't have a direct relation defined in Cart model yet, we can't easily rely on Eloquent relation unless we add it to Cart model. 
            // But assuming we will add 'variation' relation to Cart model or just manually load it if it's simpler here, 
            // but correct way is to add relation to Cart model first. 
            // Let's assume we will add 'variation' to Cart model in next step or I can add it now. 
            // For now, I'll rely on a later step to update Cart model, but here I will assume relation exists or I'll just skip 'with' and let it lazy load or I'll add `variation` relation to Cart model in the same step.
            // Actually I'll just assume relation `variation` exists on Cart model. I should update Cart model first? No I'll do it after this.)
            ->with(['variation'])
            ->get()
            ->map(function ($cartItem) {
                return [
                    'id' => $cartItem->id,
                    'auction_id' => $cartItem->auction_id,
                    'variation_id' => $cartItem->variation_id,
                    'type' => $cartItem->type,
                    'quantity' => $cartItem->quantity,
                    'price' => $cartItem->price,
                    'auction' => [
                        'id' => $cartItem->auction->id,
                        'title' => $cartItem->auction->title,
                        'slug' => $cartItem->auction->slug ?? null,
                        'image' => $cartItem->auction->image,
                        'description' => $cartItem->auction->description ?? null,
                        'buy_now_price' => $cartItem->auction->buy_now_price,
                        'minimum_bid' => $cartItem->auction->minimum_bid,
                        'list_type' => $cartItem->auction->list_type,
                    ],
                    'product' => [
                        'id' => $cartItem->auction->id,
                        'title' => $cartItem->auction->title,
                        'image' => $cartItem->auction->image,
                        'buy_now_price' => $cartItem->auction->buy_now_price,
                        'minimum_bid' => $cartItem->auction->minimum_bid,
                        'list_type' => $cartItem->auction->list_type,
                    ],
                    'variation' => $cartItem->variation ? [
                        'id' => $cartItem->variation->id,
                        'name' => $cartItem->variation->name,
                        'price' => $cartItem->variation->price,
                    ] : null,
                ];
            });

        return response()->json([
            'success' => true,
            'cart' => $cartItems,
            'count' => $cartItems->count(),
        ]);
    }

    /**
     * Add item to cart
     */
    public function add(Request $request)
    {
        // Normalize: treat variation_id 0, empty string as null to avoid validation issues
        $variationId = $request->variation_id;
        if ($variationId === '' || $variationId === '0' || (is_numeric($variationId) && (int) $variationId === 0)) {
            $request->merge(['variation_id' => null]);
        }

        \Log::info('[Cart] Add request: ' . json_encode($request->only(['auction_id', 'type', 'variation_id'])));

        $validator = Validator::make($request->all(), [
            'auction_id' => 'required|integer|exists:auctions,id',
            'type' => 'nullable|string|in:product,featured',
            'variation_id' => 'nullable|integer|exists:product_variations,id',
        ]);

        if ($validator->fails()) {
            \Log::warning('[Cart] Validation failed: ' . json_encode($validator->errors()->toArray()));
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $user = $request->user();
        $auction = Auction::with('variations')->findOrFail($request->auction_id);
        $variationId = $request->variation_id;

        // Check if product is already in cart
        $existingCartItem = Cart::where('user_id', $user->id)
            ->where('auction_id', $auction->id)
            ->where('type', $request->type ?? 'product')
            ->where(function ($q) use ($variationId) {
                if ($variationId === null) {
                    $q->whereNull('variation_id');
                } else {
                    $q->where('variation_id', $variationId);
                }
            })
            ->first();

        if ($existingCartItem) {
            \Log::info('[Cart] Already in cart: auction_id=' . $auction->id);
            return response()->json([
                'success' => false,
                'message' => 'Product already in cart',
                'reason' => 'duplicate',
            ], 400);
        }

        // Determine price
        if ($request->type === 'featured') {
            $price = 15000; // Fixed PKR base price for Featured Listing promotion
        } else {
            if ($variationId) {
                $variation = ProductVariation::find($variationId);
                if ($variation && $variation->auction_id == $auction->id) {
                    $originalPrice = $variation->price;
                    $discountType = $variation->discount_type;
                    $discountValue = $variation->discount_value;
                } else {
                    \Log::warning('[Cart] Invalid variation: variation_id=' . $variationId . ', auction_id=' . $auction->id);
                    return response()->json([
                        'success' => false,
                        'message' => 'Invalid variation selected',
                        'reason' => 'invalid_variation',
                    ], 400);
                }
            } else {
                // use buy_now_price if available, otherwise minimum_bid for regular products
                $originalPrice = $auction->buy_now_price ?? $auction->minimum_bid ?? 0;
                $discountType = $auction->discount_type ?? null;
                $discountValue = $auction->discount_value ?? 0;

                // When auction-level price is 0 but product has variations, use min variation price
                if ($originalPrice <= 0 && $auction->variations && $auction->variations->isNotEmpty()) {
                    $minVar = $auction->variations->sortBy('price')->first();
                    if ($minVar && $minVar->price > 0) {
                        $originalPrice = $minVar->price;
                        $discountType = $minVar->discount_type;
                        $discountValue = $minVar->discount_value ?? 0;
                    }
                }
            }

            // Calculate Discount
            $price = $originalPrice;
            if ($discountType && $discountValue > 0) {
                if ($discountType === 'percent') {
                    $price = $originalPrice - ($originalPrice * ($discountValue / 100));
                } elseif ($discountType === 'flat') {
                    $price = $originalPrice - $discountValue;
                }
            }
            if ($price < 0) {
                $price = 0;
            }
        }

        if ($price <= 0) {
            \Log::warning('[Cart] Invalid price: auction_id=' . $auction->id . ', buy_now=' . ($auction->buy_now_price ?? 'null') . ', min_bid=' . ($auction->minimum_bid ?? 'null'));
            return response()->json([
                'success' => false,
                'message' => 'This item cannot be added to cart. It does not have a valid purchase price.',
                'reason' => 'invalid_price',
            ], 400);
        }

        $cartItem = Cart::create([
            'user_id' => $user->id,
            'auction_id' => $auction->id,
            'variation_id' => $variationId,
            'type' => $request->type ?? 'product',
            'quantity' => 1,
            'price' => $price,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Product added to cart successfully',
            'cart_item' => $cartItem,
        ]);
    }

    /**
     * Remove item from cart
     */
    public function remove(Request $request, $id)
    {
        $user = $request->user();

        $cartItem = Cart::where('id', $id)
            ->where('user_id', $user->id)
            ->first();

        if (!$cartItem) {
            return response()->json([
                'success' => false,
                'message' => 'Cart item not found',
            ], 404);
        }

        $cartItem->delete();

        return response()->json([
            'success' => true,
            'message' => 'Item removed from cart successfully',
        ]);
    }

    /**
     * Update cart item quantity
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'quantity' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $user = $request->user();

        $cartItem = Cart::where('id', $id)
            ->where('user_id', $user->id)
            ->first();

        if (!$cartItem) {
            return response()->json([
                'success' => false,
                'message' => 'Cart item not found',
            ], 404);
        }

        $cartItem->update([
            'quantity' => $request->quantity,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Cart updated successfully',
            'cart_item' => $cartItem,
        ]);
    }

    /**
     * Get cart count
     */
    public function count(Request $request)
    {
        $user = $request->user();

        $count = Cart::where('user_id', $user->id)->count();

        return response()->json([
            'success' => true,
            'count' => $count,
        ]);
    }

    /**
     * Clear all items from cart
     */
    public function clear(Request $request)
    {
        $user = $request->user();

        Cart::where('user_id', $user->id)->delete();

        return response()->json([
            'success' => true,
            'message' => 'Cart cleared successfully',
        ]);
    }
}
