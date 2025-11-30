<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AuctionController;
use App\Http\Controllers\AuctionCategoryController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\BidController;
use App\Http\Controllers\WalletController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FavoritesController;
use App\Http\Controllers\PhoneAuthController;
use App\Http\Controllers\Auth\OAuthController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\VerificationCodeController;
use App\Http\Controllers\PaymentRequestController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\IdentityController;
use App\Http\Controllers\Api\SeoController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\IndividualVerificationController;
use App\Http\Controllers\CorporateVerificationController;
use App\Http\Controllers\PropertyVerificationController;
use App\Http\Controllers\VehicleVerificationController;
use App\Http\Controllers\Api\BlogApiController;
use App\Http\Controllers\Api\CurrencyController;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\BuyNowInquiryController;

Route::get('/currencies', [CurrencyController::class, 'index']);
Route::get('/blogs', [BlogApiController::class, 'index']);
Route::get('/blogs/{slug}', [BlogApiController::class, 'show']);

Route::middleware('auth:sanctum')->post('/validate-referral', [ProfileController::class, 'validateReferral']);
Route::middleware('auth:sanctum')->get('/me', function (Request $request) {
    return $request->user();
});

// Buy Now Inquiry - Public route (no auth required)
Route::post('/buy-now-inquiry', [BuyNowInquiryController::class, 'store']);

// Admin routes (require authentication)
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/buy-now-inquiries', [BuyNowInquiryController::class, 'index']);
    Route::patch('/buy-now-inquiries/{id}/status', [BuyNowInquiryController::class, 'updateStatus']);
});
Route::middleware('auth:sanctum')->post('user/close', [AuthController::class,'closeAccount']);

Route::middleware('auth:sanctum')
     ->apiResource('vehicle-verifications', VehicleVerificationController::class);
Route::get('products/filter', [AuctionController::class, 'filtered']);

Route::middleware('auth:sanctum')->group(function(){
    Route::apiResource('property-verifications', PropertyVerificationController::class)
     ->only(['index','store','show','update','destroy']);

    Route::post('property-verifications/{pv}/accept',   [PropertyVerificationController::class,'accept']);
    Route::post('property-verifications/{pv}/decline',  [PropertyVerificationController::class,'decline']);
});


Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('corporate-verifications', CorporateVerificationController::class);
    Route::post('corporate-verifications/{id}/accept',  [CorporateVerificationController::class, 'accept']);
    Route::post('corporate-verifications/{id}/decline', [CorporateVerificationController::class, 'decline']);
});
Route::middleware('auth:sanctum')->apiResource(
  'individual-verifications',
  IndividualVerificationController::class
);

Route::get('/seo/{slug}', [SeoController::class, 'show']);

    Route::middleware('auth:sanctum')->post("/identity", [IdentityController::class, "store"]);
	Route::middleware('auth:sanctum')->get("/get-identity", [IdentityController::class, "get_identity"]);

Route::get('/stats', [SliderController::class, 'getStats']);
Route::post('/forgot-password', [PasswordController::class, 'sendResetLink']);
Route::post('/reset-password', [PasswordController::class, 'reset']);
Route::post('/update-password', [PasswordController::class, 'update'])->middleware('auth:sanctum');

//Route::apiResource('products', ProductController::class);
Route::post('/google-login', [AuthController::class, 'googleLogin']);
Route::post('/google-register', [AuthController::class, 'googleRegister']);


Route::middleware('auth:sanctum')->get('/users/{id}', [UserController::class, 'verifyUser']);


  Route::post('/verify-code', [VerificationCodeController::class, 'verifyCode']);
    Route::post('/send-verification', [VerificationCodeController::class, 'sendVerificationCode']);
Route::post('/contact', [ContactController::class, 'store']);





Route::get('/get-subcategories/{id}', [AuctionCategoryController::class, 'getSubcategories']);
Route::get('/get-childern/{id}', [AuctionCategoryController::class, 'getChildern']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/get-image', [UserController::class, 'getUserProfile']);
    Route::get('/notifications', [NotificationController::class, 'getNotifications']);
    Route::post('/notifications/read/{id}', [NotificationController::class, 'markAsRead']);

    Route::delete('/notifications/{id}', [NotificationController::class, 'deleteNotification']);
    Route::get('/notifications/unread-count', [NotificationController::class, 'getUnreadCount']);
   Route::post('/notifications/mark-all-read', [NotificationController::class, 'markAllAsRead']);


});



Route::get('/example', function () {
    return response()->json(['message' => 'API route is working']);
});

Route::post('/oauth-login', [OAuthController::class, 'login']);
Route::post('/oauth-register', [OAuthController::class, 'register']);

Route::get('/test-send-otp', function () {
    $service = new \App\Services\TwilioService();
    $phone = '+923473639710'; // Replace with a valid number
    $otp = rand(1000, 9999);

    if ($service->sendOtp($phone, $otp)) {
        return "OTP sent successfully!";
    }

    return "Failed to send OTP.";
});

Route::post('/send-verification-code', [VerificationCodeController::class, 'sendVerificationCode']);
Route::post('/verify-code', [VerificationCodeController::class, 'verifyCode']);

Route::post('/send-otp', [PhoneAuthController::class, 'sendOtp']);
Route::post('/verify-otp', [PhoneAuthController::class, 'verifyOtp']);
Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);
Route::post('/register', [AuthController::class, 'register']);
Route::get('/get-category-sell', [AuctionCategoryController::class, 'get_category_sell']);
Route::get('/get-category', [AuctionCategoryController::class, 'get_category']);
Route::get('/get-subcategories/{id}', [AuctionCategoryController::class, 'getSubcategories']);

Route::get('/get-products', [AuctionController::class, 'get_products']);
Route::get('/product/{slug}', [AuctionController::class, 'products_details']);
Route::get('/account-settings', [UserController::class, 'account_settings']);
Route::get('/get-featured', [AuctionController::class, 'get_featured']);
Route::get('/get-featured-vehicle', [AuctionController::class, 'get_featured_vehicle']);
Route::get('/get-featured-service', [AuctionController::class, 'get_featured_service']);
Route::get('/get-featured-realstate', [AuctionController::class, 'get_featured_realstate']);
Route::get('/get-vehicle', [AuctionController::class, 'get_vehicle']);
Route::get('/get-realestate', [AuctionController::class, 'get_realestate']);
Route::get('/get-service', [AuctionController::class, 'get_service']);
Route::get('/get-latest-vehicles', [AuctionController::class, 'get_latest_vehicles']);
Route::get('/get-latest-properties', [AuctionController::class, 'get_latest_properties']);
Route::get('/get-latest-normal-lists', [AuctionController::class, 'get_latest_normal_lists']);
Route::get('/get-latest-auctions', [AuctionController::class, 'get_latest_auctions']);
Route::get('/get-all-categories', [AuctionCategoryController::class, 'all_categories']);

//Route::get('/wallet', [WalletController::class, 'balance']);
Route::middleware('auth:sanctum')->group(function () {
  
    Route::post('/change-password', [ProfileController::class, 'updatePassword']);
    Route::post('/auctions_store', [AuctionController::class, 'api_store']);
    Route::post('/auctions_save_draft', [AuctionController::class, 'api_save_draft']);
    Route::get('/auctions_get_draft', [AuctionController::class, 'api_get_draft']);
    // Edit/Update Auction API (for frontend edit form)
Route::post('auctions_update/{id}', [AuctionController::class, 'api_update']);
Route::get('auctions/{id}', [AuctionController::class, 'api_show']);
    Route::post('/listings/{id}/cancel', [AuctionController::class, 'cancel']);
    Route::get('/listings', [AuctionController::class, 'listings']);
    Route::post('/bids', [BidController::class, 'placeBid']);
    Route::post('/favorites/add', [FavoritesController::class, 'add']);
    Route::get('/favorites', [FavoritesController::class, 'index']);
    Route::post('/favorites/check', [FavoritesController::class, 'check']);
    Route::get('/account-settings', [ProfileController::class, 'getProfile']);
    Route::post('/user/update', [ProfileController::class, 'updateProfile']);
    Route::get('/user/address', [ProfileController::class, 'getAddress']);
    Route::post('/user/address', [ProfileController::class, 'updateAddress']);
    Route::post('/user/address-mobile', [ProfileController::class, 'updateAddressMobile']); 
    Route::get('/user/notifications', [ProfileController::class, 'getNotificationSettings']);
    Route::post('/user/notifications', [ProfileController::class, 'updateNotificationSettings']);
    Route::post('/user/change-password', [ProfileController::class, 'updatePassword']);
    Route::post('/identity-verification', [ProfileController::class, 'saveIdentityVerification']);
    Route::get('/get-identity-verification', [ProfileController::class, 'getIdentityVerification']);
    Route::get('/check-verification-status', [ProfileController::class, 'checkVerificationStatus']);
    Route::get('/user/details', [ProfileController::class, 'getUserDetails']);
    Route::post('/user/save-login', [ProfileController::class, 'saveLoginDetails']);
    Route::post('/user/change-password', [ProfileController::class, 'changePassword']);
    Route::get('/dashboard', [AuctionController::class, 'dashboard']);
    Route::get('/auctions', [AuctionController::class, 'getAuctionsByStatus']);
    Route::post('/payment-methods', [PaymentController::class, 'savePaymentMethod']);  // Save payment method
    Route::delete('/payment-methods/{id}', [PaymentController::class, 'deletePaymentMethod'])->middleware('auth:sanctum');
Route::patch('/payment-methods/{id}', [PaymentController::class, 'updatePaymentMethod'])->middleware('auth:sanctum');

    Route::get('/payment-methods', [PaymentController::class, 'getPaymentMethods']);   // List payment methods
    Route::post('/payment-methods/default', [PaymentController::class, 'setDefaultPaymentMethod']); // Set default
    Route::post('/payment/process', [PaymentController::class, 'processPayment']); // Make payment
    Route::post('/payment-requests', [PaymentRequestController::class, 'store']); // Store request
    Route::get('/payment-requests', [PaymentRequestController::class, 'index']); // Get user's requests
    Route::put('/payment-requests/{id}/status', [PaymentRequestController::class, 'updateStatus']); // Update status (Admin only)

    Route::get('/wallet', [WalletController::class, 'getWallet']);
        Route::post('/wallet/deduct', [WalletController::class, 'deductMoney']);
    Route::post('/wallet/add', [WalletController::class, 'addMoney']);
    Route::get('/wallet/transactions', [WalletController::class, 'getTransactions']);
    Route::post('/wallet/stripe-payment', [WalletController::class, 'stripePayment']);
    Route::post('/wallet/paypal-payment', [WalletController::class, 'paypalPayment']);
    Route::post('/stripe-payment', [PaymentController::class, 'createPaymentIntent']);
    Route::get('/paypal/success', [PaymentController::class, 'paypalSuccess'])->name('paypal.success');
    Route::get('/paypal/cancel', [PaymentController::class, 'paypalCancel'])->name('paypal.cancel');
});
Route::get('/highest-bid/{auctionId}', [BidController::class, 'getHighestBid']);
Route::post('/paypal-payment', [PaymentController::class, 'processPayPalPayment']);
Route::get('get-category-product/{id}', [AuctionController::class, 'get_products_category']);
Route::get('/product/{id}/increment-views', [AuctionController::class, 'products_views']);
Route::get('/get-countries', [AuctionController::class, 'get_countries']);
Route::get('/get-states/{id}', [AuctionController::class, 'get_states']);
Route::get('/get-states-by-country-name/{id}', [AuctionController::class, 'get_states_country_name']);
Route::get('/get-cities/{id}', [AuctionController::class, 'get_cities']);
Route::get('/get-cities-by-state-name/{id}', [AuctionController::class, 'get_cities_by_state_name']);
Route::get('/get-slider', [SliderController::class, 'get_slider']);
Route::get('/get-slider-vehicle', [SliderController::class, 'get_slider_vehicle']);
Route::get('/get-slider-service', [SliderController::class, 'get_slider_service']);
Route::get('/get-slider-realstate', [SliderController::class, 'get_slider_realstate']);
Route::get('/search-auctions', [AuctionController::class, 'search']);
Route::get('/get-auctions', [AuctionController::class, 'filterAuctions']);

// Route::middleware('auth:sanctum')->group(function () {
//     Route::post('/bids', [BidController::class, 'placeBid']);
// });

//Route::post('/bids', [BidController::class, 'placeBid']);


// routes/api.php
//Route::post('/favorites/add', [FavoritesController::class, 'index']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // Route::middleware(['role:admin'])->group(function () {
    //     Route::get('/admin-data', [AdminController::class, 'index']);
    // });

    // Route::middleware(['role:vendor'])->group(function () {
    //     Route::get('/vendor-data', [VendorController::class, 'index']);
    // });

    // Route::middleware(['role:user'])->group(function () {
    //     Route::get('/user-data', [UserController::class, 'index']);
    // });
});

Route::prefix('mobile')->name('api.auth.')->middleware(['auth:sanctum'])->group(function(){
    
    
    Route::get('/user-profile', [ProfileController::class, 'getProfileMobile']);
    
    
});
