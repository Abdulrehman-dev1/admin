<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Auction;
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
            ->with(['auction' => function ($query) {
                $query->select('id', 'title', 'slug', 'image', 'minimum_bid', 'buy_now_price', 'is_buynow', 'list_type', 'status', 'description');
            }])
            ->get()
            ->map(function ($cartItem) {
                return [
                    'id' => $cartItem->id,
                    'auction_id' => $cartItem->auction_id,
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
        $validator = Validator::make($request->all(), [
            'auction_id' => 'required|integer|exists:auctions,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $user = $request->user();
        $auction = Auction::findOrFail($request->auction_id);

        // Check if product is already in cart
        $existingCartItem = Cart::where('user_id', $user->id)
            ->where('auction_id', $auction->id)
            ->first();

        if ($existingCartItem) {
            return response()->json([
                'success' => false,
                'message' => 'Product already in cart',
            ], 400);
        }

        // Determine price - use buy_now_price if available, otherwise minimum_bid
        $price = $auction->buy_now_price ?? $auction->minimum_bid ?? 0;

        if ($price <= 0) {
            return response()->json([
                'success' => false,
                'message' => 'Product does not have a valid price',
            ], 400);
        }

        $cartItem = Cart::create([
            'user_id' => $user->id,
            'auction_id' => $auction->id,
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
