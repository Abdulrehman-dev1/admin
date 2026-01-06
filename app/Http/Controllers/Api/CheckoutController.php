<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Cart;
use App\Models\Auction;
use App\Models\NewNotification;
use App\Mail\OrderPlacedMail;
use App\Mail\AdminOrderNotification;
use App\Mail\SellerOrderNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use Stripe\Stripe;
use Stripe\PaymentIntent;
use Illuminate\Support\Facades\Log;

class CheckoutController extends Controller
{
    /**
     * Create payment intent for Stripe
     */
    public function createPaymentIntent(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'amount' => 'required|numeric|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Get Stripe secret key from env
            $stripeSecret = env('STRIPE_SECRET');

            // Validate that we have a secret key (must start with 'sk_')
            if (empty($stripeSecret)) {
                // If not set, use hardcoded test key (same as PaymentController line 84)
                $stripeSecret = 'sk_test_6fErHC2ev2jizSKlYJozlfb500CPZYW2La';
                Log::info('STRIPE_SECRET not set in .env, using fallback test key.');
            } elseif (strpos($stripeSecret, 'pk_') === 0) {
                // If it's a publishable key, that's wrong - return error
                Log::error('STRIPE_SECRET in .env is set to publishable key (pk_). Must use secret key (sk_).');
                return response()->json([
                    'success' => false,
                    'message' => 'Configuration Error: STRIPE_SECRET must be a secret key (sk_...) not publishable key (pk_...). Please check your .env file.',
                ], 500);
            } elseif (strpos($stripeSecret, 'sk_') !== 0) {
                // If it doesn't start with sk_, use fallback
                Log::warning('STRIPE_SECRET format invalid, using fallback test key.');
                $stripeSecret = 'sk_test_6fErHC2ev2jizSKlYJozlfb500CPZYW2La';
            }

            // Ensure we have a valid secret key before proceeding
            if (strpos($stripeSecret, 'sk_') !== 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid Stripe configuration. Please check STRIPE_SECRET in .env file.',
                ], 500);
            }

            Stripe::setApiKey($stripeSecret);

            $amountInCents = (int) ($request->amount * 100); // Convert to cents

            $paymentIntent = PaymentIntent::create([
                'amount' => $amountInCents,
                'currency' => 'usd', // Stripe standard currency
                'payment_method_types' => ['card'],
                'metadata' => [
                    'user_id' => $request->user()->id,
                ],
            ]);

            return response()->json([
                'success' => true,
                'clientSecret' => $paymentIntent->client_secret,
            ]);
        } catch (\Exception $e) {
            Log::error('Stripe Payment Intent Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to create payment intent: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Process checkout and create order
     */
    public function processCheckout(Request $request)
    {
        // Handle FormData - Parse order_data if sent as JSON string
        $orderData = $request->all();
        if ($request->has('order_data')) {
            $orderDataJson = is_string($request->order_data) ? json_decode($request->order_data, true) : $request->order_data;
            if (is_array($orderDataJson)) {
                $orderData = array_merge($orderData, $orderDataJson);
            }
        }

        // Merge items if sent separately
        if ($request->has('items') && is_string($request->items)) {
            $orderData['items'] = json_decode($request->items, true);
        }

        $hasPromotion = $orderData['has_promotion'] ?? false;

        $validator = Validator::make($orderData, [
            'items' => 'required|array|min:1',
            'items.*.auction_id' => 'required|integer|exists:auctions,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.price' => 'required|numeric|min:0',

            // Billing Details
            'billing_name' => 'required|string|max:255',
            'billing_email' => 'required|email|max:255',
            'billing_phone' => 'required|string|max:20',
            'billing_address_line1' => $hasPromotion ? 'nullable|string|max:500' : 'required|string|max:500',
            'billing_address_line2' => 'nullable|string|max:500',
            'billing_city' => $hasPromotion ? 'nullable|string|max:100' : 'required|string|max:100',
            'billing_state' => $hasPromotion ? 'nullable|string|max:100' : 'required|string|max:100',
            'billing_postal_code' => 'nullable|string|max:20',
            'billing_country' => $hasPromotion ? 'nullable|string|max:100' : 'required|string|max:100',

            // Shipping Details
            'shipping_name' => $hasPromotion ? 'nullable|string|max:255' : 'required|string|max:255',
            'shipping_email' => $hasPromotion ? 'nullable|email|max:255' : 'required|email|max:255',
            'shipping_phone' => $hasPromotion ? 'nullable|string|max:20' : 'required|string|max:20',
            'shipping_address_line1' => $hasPromotion ? 'nullable|string|max:500' : 'required|string|max:500',
            'shipping_address_line2' => 'nullable|string|max:500',
            'shipping_city' => $hasPromotion ? 'nullable|string|max:100' : 'required|string|max:100',
            'shipping_state' => $hasPromotion ? 'nullable|string|max:100' : 'required|string|max:100',
            'shipping_postal_code' => 'nullable|string|max:20',
            'shipping_country' => $hasPromotion ? 'nullable|string|max:100' : 'required|string|max:100',

            // Payment Details
            'payment_method' => 'required|in:stripe,cod,bank_transfer',
            'receipt_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120', // 5MB max
            'transaction_id' => 'nullable|string|max:255', // Required for Stripe
            'payment_intent_id' => 'nullable|string|max:255', // For Stripe verification

            // Order Summary
            'subtotal' => 'required|numeric|min:0',
            'tax' => 'nullable|numeric|min:0',
            'shipping_cost' => 'nullable|numeric|min:0',
            'total' => 'required|numeric|min:0',

            'notes' => 'nullable|string|max:1000',
        ]);


        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $user = $request->user();

        // Verify Stripe payment if payment method is Stripe
        if (($orderData['payment_method'] ?? null) === 'stripe') {
            if (!($orderData['payment_intent_id'] ?? null)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Payment intent ID is required for Stripe payments',
                ], 400);
            }

            try {
                // Get Stripe secret key from env
                $stripeSecret = env('STRIPE_SECRET');

                // Validate that we have a secret key (must start with 'sk_')
                if (empty($stripeSecret)) {
                    // If not set, use hardcoded test key
                    $stripeSecret = 'sk_test_6fErHC2ev2jizSKlYJozlfb500CPZYW2La';
                } elseif (strpos($stripeSecret, 'pk_') === 0) {
                    // If it's a publishable key, that's wrong - return error
                    Log::error('STRIPE_SECRET in .env is set to publishable key (pk_). Must use secret key (sk_).');
                    return response()->json([
                        'success' => false,
                        'message' => 'Configuration Error: STRIPE_SECRET must be a secret key (sk_...) not publishable key (pk_...).',
                    ], 500);
                } elseif (strpos($stripeSecret, 'sk_') !== 0) {
                    // If it doesn't start with sk_, use fallback
                    $stripeSecret = 'sk_test_6fErHC2ev2jizSKlYJozlfb500CPZYW2La';
                }

                // Ensure we have a valid secret key before proceeding
                if (strpos($stripeSecret, 'sk_') !== 0) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Invalid Stripe configuration.',
                    ], 500);
                }

                Stripe::setApiKey($stripeSecret);
                $paymentIntent = PaymentIntent::retrieve($orderData['payment_intent_id']);

                if ($paymentIntent->status !== 'succeeded') {
                    return response()->json([
                        'success' => false,
                        'message' => 'Payment was not successful. Please try again.',
                    ], 400);
                }

                // Verify amount matches
                $expectedAmount = (int) ($orderData['total'] * 100);
                if ($paymentIntent->amount !== $expectedAmount) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Payment amount mismatch',
                    ], 400);
                }
            } catch (\Exception $e) {
                Log::error('Stripe Payment Verification Error: ' . $e->getMessage());
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to verify payment: ' . $e->getMessage(),
                ], 500);
            }
        }

        DB::beginTransaction();

        try {
            // Handle receipt image upload for bank transfer
            $receiptImagePath = null;

            // Debug logging
            Log::info('=== Receipt Image Upload Debug ===');
            Log::info('Has File: ' . ($request->hasFile('receipt_image') ? 'YES' : 'NO'));
            Log::info('Payment Method: ' . $orderData['payment_method']);

            if ($request->hasFile('receipt_image')) {
                $file = $request->file('receipt_image');
                Log::info('File Name: ' . $file->getClientOriginalName());
                Log::info('File Size: ' . $file->getSize() . ' bytes');
                Log::info('File MIME: ' . $file->getMimeType());

                try {
                    $fileName = 'receipt_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

                    // Save to public/assets/images/recipt/
                    $uploadPath = public_path('assets/images/recipt');

                    // Create directory if not exists
                    if (!file_exists($uploadPath)) {
                        mkdir($uploadPath, 0777, true);
                        Log::info('Created directory: ' . $uploadPath);
                    }

                    Log::info('Upload directory exists: ' . (file_exists($uploadPath) ? 'YES' : 'NO'));
                    Log::info('Upload directory writable: ' . (is_writable($uploadPath) ? 'YES' : 'NO'));

                    // Move file to public directory
                    $fullPath = $uploadPath . '/' . $fileName;
                    if ($file->move($uploadPath, $fileName)) {
                        $receiptImagePath = 'assets/images/recipt/' . $fileName;
                        Log::info('File upload successful: ' . $receiptImagePath);
                        Log::info('Full path: ' . $fullPath);
                    } else {
                        Log::error('File move failed');
                    }

                } catch (\Exception $e) {
                    Log::error('Receipt upload error: ' . $e->getMessage());
                    Log::error('Stack trace: ' . $e->getTraceAsString());
                }
            } else {
                Log::warning('No receipt image file found in request');
                Log::info('All Request Files: ' . json_encode($request->allFiles()));
            }

            // If no receipt image, set to null explicitly
            if (empty($receiptImagePath)) {
                $receiptImagePath = null;
            }

            Log::info('Final Receipt Path: ' . ($receiptImagePath ?? 'NULL'));
            Log::info('=== End Receipt Debug ===');

            // Determine payment status
            $paymentStatus = 'pending';
            if ($orderData['payment_method'] === 'stripe') {
                $paymentStatus = 'paid';
            } elseif ($orderData['payment_method'] === 'bank_transfer') {
                $paymentStatus = 'pending';
            } elseif ($orderData['payment_method'] === 'cod') {
                $paymentStatus = 'pending';
            }
            // SECURITY: Recalculate totals and enforce promotion prices on the backend
            $calculatedSubtotal = 0;
            $processedItems = [];
            foreach ($orderData['items'] as $item) {
                $itemPrice = (float) ($item['price'] ?? 0);
                $itemType = $item['type'] ?? 'product';

                // Force FREE price for promotions
                if ($itemType === 'featured') {
                    $itemPrice = 0; // FREE for now
                }

                $itemQuantity = (int) ($item['quantity'] ?? 1);
                $itemSubtotal = $itemPrice * $itemQuantity;

                $calculatedSubtotal += $itemSubtotal;

                $processedItems[] = [
                    'auction_id' => $item['auction_id'],
                    'variation_id' => $item['variation_id'] ?? null,
                    'type' => $itemType,
                    'quantity' => $itemQuantity,
                    'price' => $itemPrice,
                    'subtotal' => $itemSubtotal,
                ];
            }

            // Update orderData with backend-verified items and totals
            $orderData['items'] = $processedItems;
            $orderData['subtotal'] = $calculatedSubtotal;
            $orderData['tax'] = (float) ($orderData['tax'] ?? 0);
            $orderData['shipping_cost'] = (float) ($orderData['shipping_cost'] ?? 0);
            $orderData['total'] = $orderData['subtotal'] + $orderData['tax'] + $orderData['shipping_cost'];

            // VALIDATION: Validate receipt for bank transfer (only if total > 0)
            if ($orderData['payment_method'] === 'bank_transfer' && $orderData['total'] > 0 && !$request->hasFile('receipt_image')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Payment receipt is required for bank transfer',
                ], 422);
            }

            // Determine payment status and order status
            $paymentStatus = 'pending';
            $orderStatus = 'pending';

            if ($orderData['payment_method'] === 'stripe') {
                $paymentStatus = 'paid';
            } elseif ($orderData['payment_method'] === 'bank_transfer') {
                $paymentStatus = 'pending';
            } elseif ($orderData['payment_method'] === 'cod') {
                $paymentStatus = 'pending';
            }

            // For Free Promotions: Auto-complete the order
            if ($hasPromotion && $orderData['total'] <= 0) {
                $paymentStatus = 'paid';
                $orderStatus = 'completed';
                if (!isset($orderData['payment_method']) || empty($orderData['payment_method'])) {
                    $orderData['payment_method'] = 'free_promotion';
                }
            }

            // Create order
            $order = Order::create([
                'user_id' => $user->id,
                'order_number' => Order::generateOrderNumber(),
                'is_promotion' => $hasPromotion,
                'billing_name' => $orderData['billing_name'],
                'billing_email' => $orderData['billing_email'],
                'billing_phone' => $orderData['billing_phone'],
                'billing_address_line1' => $orderData['billing_address_line1'] ?? ($hasPromotion ? null : 'N/A'),
                'billing_address_line2' => $orderData['billing_address_line2'] ?? null,
                'billing_city' => $orderData['billing_city'] ?? ($hasPromotion ? null : 'N/A'),
                'billing_state' => $orderData['billing_state'] ?? ($hasPromotion ? null : 'N/A'),
                'billing_postal_code' => $orderData['billing_postal_code'] ?? ($hasPromotion ? null : 'N/A'),
                'billing_country' => $orderData['billing_country'] ?? ($hasPromotion ? null : 'N/A'),
                'shipping_name' => $orderData['shipping_name'] ?? $orderData['billing_name'],
                'shipping_email' => $orderData['shipping_email'] ?? $orderData['billing_email'],
                'shipping_phone' => $orderData['shipping_phone'] ?? $orderData['billing_phone'],
                'shipping_address_line1' => $orderData['shipping_address_line1'] ?? ($hasPromotion ? null : 'N/A'),
                'shipping_address_line2' => $orderData['shipping_address_line2'] ?? null,
                'shipping_city' => $orderData['shipping_city'] ?? ($hasPromotion ? null : 'N/A'),
                'shipping_state' => $orderData['shipping_state'] ?? ($hasPromotion ? null : 'N/A'),
                'shipping_postal_code' => $orderData['shipping_postal_code'] ?? ($hasPromotion ? null : 'N/A'),
                'shipping_country' => $orderData['shipping_country'] ?? ($hasPromotion ? null : 'N/A'),
                'subtotal' => $orderData['subtotal'],
                'tax' => $orderData['tax'],
                'shipping_cost' => $orderData['shipping_cost'],
                'total' => $orderData['total'],
                'payment_method' => $orderData['payment_method'],
                'payment_status' => $paymentStatus,
                'transaction_id' => $orderData['transaction_id'] ?? $orderData['payment_intent_id'] ?? null,
                'receipt_image' => $receiptImagePath,
                'status' => $orderStatus,
                'notes' => $orderData['notes'] ?? null,
            ]);

            // Create order items and close auctions
            $auctionIds = [];
            foreach ($orderData['items'] as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'auction_id' => $item['auction_id'],
                    'variation_id' => $item['variation_id'] ?? null,
                    'type' => $item['type'] ?? 'product',
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'subtotal' => $item['subtotal'],
                ]);

                // Update Auction featured_name if it's a promotion
                if (($item['type'] ?? 'product') === 'featured') {
                    \App\Models\Auction::where('id', $item['auction_id'])
                        ->update(['featured_name' => 'home_featured']);
                }

                $auctionIds[] = $item['auction_id'];
            }

            // Close auctions that were ordered (only products, excluding normal_list)
            $productAuctionIds = collect($orderData['items'])
                ->filter(fn($item) => ($item['type'] ?? 'product') === 'product')
                ->pluck('auction_id')
                ->toArray();

            if (!empty($productAuctionIds)) {
                // Only close auctions that are NOT 'normal_list'
                // Assuming 'normal_list' items behave like standard e-commerce products and remain active
                Auction::whereIn('id', $productAuctionIds)
                    ->where('list_type', '!=', 'normal_list')
                    ->update(['status' => 'closed']);
            }

            // Clear cart if items were from cart
            $cartItemIds = collect($orderData['items'])->pluck('cart_item_id')->filter()->toArray();
            if (!empty($cartItemIds)) {
                Cart::whereIn('id', $cartItemIds)
                    ->where('user_id', $user->id)
                    ->delete();
            }

            // Send notification
            NewNotification::create([
                'user_id' => $user->id,
                'title' => 'Order Placed',
                'message' => 'Your order #' . $order->order_number . ' has been placed successfully.',
                'is_read' => false,
                'type' => 'order',
                'image_url' => NewNotification::getImageForType('order') ?? null,
            ]);

            // Send order confirmation email
            try {
                // 1. Send to Buyer
                Mail::to($order->billing_email)->send(new OrderPlacedMail($order));

                // 2. Send to Admin
                Mail::to('xpertbidofficial@gmail.com')->send(new AdminOrderNotification($order));

                // 3. Send to Sellers (Vendors)
                // Group items by Seller (Auction Owner)
                $sellerItems = [];
                $order->load('items.auction.user'); // Eager load relationships

                foreach ($order->items as $item) {
                    if ($item->auction && $item->auction->user) {
                        $sellerId = $item->auction->user->id;
                        $sellerEmail = $item->auction->user->email;

                        if (!isset($sellerItems[$sellerId])) {
                            $sellerItems[$sellerId] = [
                                'email' => $sellerEmail,
                                'items' => []
                            ];
                        }
                        $sellerItems[$sellerId]['items'][] = $item;
                    }
                }

                // Send email to each seller
                foreach ($sellerItems as $sellerId => $data) {
                    if (!empty($data['email'])) {
                        Mail::to($data['email'])->send(new SellerOrderNotification($order, $data['items']));
                    }
                }

            } catch (\Exception $e) {
                Log::error('Failed to send order emails: ' . $e->getMessage());
                // Don't fail the order if email fails
            }

            DB::commit();

            // Format order data for response
            $orderData = $order->load('items')->toArray();

            // Ensure receipt_image is properly formatted
            if (!isset($orderData['receipt_image']) || empty($orderData['receipt_image']) || $orderData['receipt_image'] === '0' || $orderData['receipt_image'] === 0) {
                $orderData['receipt_image'] = null;
            }

            return response()->json([
                'success' => true,
                'message' => 'Order placed successfully',
                'order' => $orderData,
                'order_number' => $order->order_number,
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Checkout Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to process checkout: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get order details by order number
     */
    public function getOrderByNumber(Request $request, $orderNumber)
    {
        $user = $request->user();

        $order = Order::where('order_number', $orderNumber)
            ->where('user_id', $user->id)
            ->with([
                'items.auction' => function ($query) {
                    $query->select('id', 'title', 'image', 'slug');
                }
            ])
            ->first();

        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'Order not found',
            ], 404);
        }

        // Format order items with product details
        $order->items = $order->items->map(function ($item) {
            return [
                'id' => $item->id,
                'auction_id' => $item->auction_id,
                'quantity' => $item->quantity,
                'price' => $item->price,
                'subtotal' => $item->subtotal,
                'product_name' => $item->auction->title ?? 'Product',
                'auction' => [
                    'id' => $item->auction->id ?? null,
                    'title' => $item->auction->title ?? 'Product',
                    'image' => $item->auction->image ?? null,
                    'slug' => $item->auction->slug ?? null,
                ],
            ];
        });

        // Ensure receipt_image is properly formatted
        $orderData = $order->toArray();
        if (isset($orderData['receipt_image']) && ($orderData['receipt_image'] === '0' || $orderData['receipt_image'] === 0 || empty($orderData['receipt_image']))) {
            $orderData['receipt_image'] = null;
        }

        return response()->json([
            'success' => true,
            'order' => $orderData,
        ]);
    }
    /**
     * Get all orders for the authenticated user
     */
    public function myOrders(Request $request)
    {
        $user = $request->user();

        $orders = Order::where('user_id', $user->id)
            ->with([
                'items.auction' => function ($query) {
                    $query->select('id', 'title', 'image', 'slug');
                }
            ])
            ->orderBy('created_at', 'desc')
            ->get();

        // Format orders
        $formattedOrders = $orders->map(function ($order) {
            $orderData = $order->toArray();

            // Format items
            $orderData['items'] = $order->items->map(function ($item) {
                return [
                    'id' => $item->id,
                    'auction_id' => $item->auction_id,
                    'quantity' => $item->quantity,
                    'price' => $item->price,
                    'subtotal' => $item->subtotal,
                    'product_name' => $item->auction->title ?? 'Product',
                    'auction' => [
                        'id' => $item->auction->id ?? null,
                        'title' => $item->auction->title ?? 'Product',
                        'image' => $item->auction->image ?? null,
                        'slug' => $item->auction->slug ?? null,
                    ],
                ];
            });

            // Ensure receipt_image is properly formatted
            if (isset($orderData['receipt_image']) && ($orderData['receipt_image'] === '0' || $orderData['receipt_image'] === 0 || empty($orderData['receipt_image']))) {
                $orderData['receipt_image'] = null;
            }

            return $orderData;
        });

        return response()->json([
            'success' => true,
            'orders' => $formattedOrders,
        ]);
    }
}
