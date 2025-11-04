<?php
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\TrackingController;
use App\Http\Controllers\CargoTypeController;
//use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionsController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\AuctionController;
use App\Http\Controllers\AuctionCategoryController;
use App\Http\Controllers\ContentPageController;
use App\Http\Controllers\MasterSettingController;
use App\Http\Controllers\CreateLetterController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\FaqQuestionController;
use App\Http\Controllers\TestimonyController;
use App\Http\Controllers\EmailTemplateController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\PaymentRequestController;
// routes/web.php
use App\Http\Controllers\IdentityController;
use App\Http\Controllers\SliderCategoryController;
use App\Http\Controllers\PromotionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\SeoController;  // ← correct namespace
use App\Http\Controllers\AuctionStatusController;
use App\Http\Controllers\IndividualVerificationController;
use App\Http\Controllers\CorporateVerificationController;
use App\Http\Controllers\PropertyVerificationController;
use App\Http\Controllers\VehicleVerificationController;
use App\Http\Controllers\WalletController;
use App\Http\Controllers\ReferralController;
use App\Http\Controllers\BlogController;
use App\Models\IndividualVerification;
use App\Mail\VerificationDeclinedMail;

use App\Http\Controllers\ScraperController;
use App\Http\Controllers\OlxScraperController;

Route::get('/scraper', [ScraperController::class, 'index'])->name('scraper.index');
Route::post('/scraper/preview', [ScraperController::class, 'preview'])->name('scraper.preview');
Route::post('/scraper/save', [ScraperController::class, 'save'])->name('scraper.save');

// OLX Scraper Routes
Route::get('/olx-scraper', [OlxScraperController::class, 'index'])->name('olx-scraper.index');
Route::post('/olx-scraper/preview', [OlxScraperController::class, 'preview'])->name('olx-scraper.preview');
Route::post('/olx-scraper/save', [OlxScraperController::class, 'save'])->name('olx-scraper.save');

// routes/web.php
Route::middleware(['auth'])->group(function() {
    Route::resource('blogs', BlogController::class);
});


Route::prefix('referrals')->group(function () {
    Route::get('/', [ReferralController::class, 'index'])->name('referrals.index');
    Route::get('/{id}', [ReferralController::class, 'show'])->name('referrals.show');
});
Route::post('auctionstatus/{id}/decline', [AuctionStatusController::class, 'decline'])->name('auctionstatus.decline');
Route::post('/auctionstatus/{id}/accept', [AuctionStatusController::class, 'accept'])->name('auctionstatus.accept');

Route::get('/debug-decline-mail/{id}', function ($id) {
    $verification = IndividualVerification::findOrFail($id);
    // You can hard-code a reason here
    $mail = new VerificationDeclinedMail($verification, 'Testing decline');
    return $mail->render();  // Renders the Blade view as a normal HTTP response
});



// Web routes (blade)
Route::resource('vehicle-verifications', VehicleVerificationController::class);
Route::post('vehicle-verifications/{vehicleVerification}/accept',
    [VehicleVerificationController::class,'accept'])
  ->name('vehicle-verifications.accept');
Route::post('vehicle-verifications/{vehicleVerification}/decline',
    [VehicleVerificationController::class,'decline'])
  ->name('vehicle-verifications.decline');


Route::resource(
    'property-verifications',
    PropertyVerificationController::class
);

// these two *after* the resource()
Route::post(
    'property-verifications/{propertyVerification}/accept',
    [PropertyVerificationController::class, 'accept']
)->name('property-verifications.accept');

Route::post(
    'property-verifications/{propertyVerification}/decline',
    [PropertyVerificationController::class, 'decline']
)->name('property-verifications.decline');


Route::middleware(['auth'])->group(function () {
    // Resource routes for index, create, store, show, edit, update, destroy
    Route::resource('corporate-verifications', CorporateVerificationController::class)
         ->names('corporate-verifications');

    // Custom Accept / Decline actions
    Route::post('corporate-verifications/{corporate_verification}/accept', 
        [CorporateVerificationController::class, 'accept'])
        ->name('corporate-verifications.accept');

    Route::post('corporate-verifications/{corporate_verification}/decline', 
        [CorporateVerificationController::class, 'decline'])
        ->name('corporate-verifications.decline');
});

Route::middleware('auth')->group(function () {
    // resource will auto-generate index, create, store, show, edit, update, destroy
    Route::resource(
        'individual-verifications',
        IndividualVerificationController::class
    );
  Route::get('payment-requests-admin', [App\Http\Controllers\PaymentRequestController::class, 'Adminindex'])
     ->name('payment-requests-admin');
Route::get('wallets', [WalletController::class, 'index'])
         ->name('wallets.index');
    Route::put('wallets/{wallet}', [WalletController::class, 'update'])
         ->name('wallets.update');
  Route::put(
    'payment-requests/{payment_request}',
    [PaymentRequestController::class, 'update']
)->name('payment-requests.update');
});

//Route::get('payment-requests-admin', [PaymentRequestController::class, 'Adminindex']);

// List all verifications in a Blade view
// Route::get('individual-verifications', 
//     [IndividualVerificationController::class, 'index'])
//     ->name('individual-verifications.index')
//     ->middleware('auth');

// Show the “edit” form
// Route::get('individual-verifications/{id}/edit', 
//     [IndividualVerificationController::class, 'edit'])
//     ->name('individual-verifications.edit')
//     ->middleware('auth');

// Approve
Route::post('individual-verifications/{id}/accept',
    [IndividualVerificationController::class, 'accept'])
    ->name('individual-verifications.accept')
    ->middleware('auth');

// Decline
Route::post('individual-verifications/{id}/decline',
    [IndividualVerificationController::class, 'decline'])
    ->name('individual-verifications.decline')
    ->middleware('auth');

// (Optional) handle any formbased updates
// Route::put('individual-verifications/{id}', 
//     [IndividualVerificationController::class, 'update'])
//     ->name('individual-verifications.update')
//     ->middleware('auth');


// list view
Route::get('/auctionstatus', [AuctionStatusController::class, 'index'])
     ->name('auctionstatus.index');

// edit form
Route::get('/auctionstatus/{id}', [AuctionStatusController::class, 'edit'])
     ->name('auctionstatus.edit');

// approve/decline submit
Route::put('/auctionstatus/{id}', [AuctionStatusController::class, 'update'])
     ->name('auctionstatus.update');

Route::resource('auctionstatus', AuctionStatusController::class)
     ->only(['index','edit','update']);

Route::prefix('admin')
     ->middleware('auth')
     ->group(function(){
  Route::resource('seo', SeoController::class); //  use the imported class
});



Route::middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])
         ->name('dashboard');
    // any other routes behind the login wall…
});
Route::get('/promotions', [PromotionController::class, 'index'])
     ->name('promotions.index');


Route::get('/slider-categories/create', [SliderCategoryController::class, 'create'])->name('slider_categories.create');
Route::post('/slider-categories', [SliderCategoryController::class, 'store'])->name('slider_categories.store');

Route::prefix('admin')->group(function () {
    Route::get('/identities', [IdentityController::class, 'index'])->name('identities.index');
    Route::get('/identities/create', [IdentityController::class, 'create'])->name('identities.create');
    Route::post('/identities', [IdentityController::class, 'store'])->name('identities.store');
    Route::get('/identities/{id}/edit', [IdentityController::class, 'edit'])->name('identities.edit');
    Route::put('/identities/{id}', [IdentityController::class, 'update'])->name('identities.update');
});
// Route::get('/', function () {
//     if (Auth::check()) {
//         return redirect()->route('dashboard');
//     }
//     return view('index');
// });

Route::resource('sliders', SliderController::class);

Route::get('/notification', function () {
    return view('notification.index');
});
Route::get('/promotion', function () {
    return view('promotion.index');
});
Route::get('/signa', function () {
    return view('signa');
});

// Route::get('/login', function () {
//     if (Auth::check()) {
//         return redirect()->route('dashboard');
//     }
//     return view('index');
// })->name('login');
Route::get('/logout', function () {
    Auth::logout();
     return redirect()->route('login');
})->name('logout');

Route::post('/login', [AuthController::class, 'login']); // Keep the POST route for login submission
Route::post('/login-with-password', [AuthController::class, 'loginWithPassword'])->name('loginWithPassword');
Route::post('/send-verification-code', [AuthController::class, 'sendVerificationCode']);
Route::post('/signup', [AuthController::class, 'signup']);
Route::post('/verify-code', [AuthController::class, 'verifyCode']);
// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware('auth')->name('dashboard');
Route::post('/updated/{user}', [UserController::class, 'updateStatus'])
     ->name('user.status.update');
Route::middleware('auth')->group(function () {
 //   Route::resource('roles', RoleController::class);
 //   Route::get('users/{user}/roles', [RoleController::class, 'assignRoleForm'])->name('users.roles');
 //   Route::post('users/{user}/roles', [RoleController::class, 'assignRole'])->name('users.roles.store');
 //   Route::resource('permissions', PermissionsController::class);
Route::get('/get-subcategories/{id}', [AuctionCategoryController::class, 'getSubcategories']);
Route::get('/get-children/{id}', [AuctionCategoryController::class, 'getChildern']);
Route::resource('users', UserController::class);
Route::get('/profile', [UserController::class, 'show'])->name('user.profile');
Route::get('/profile/edit', [ProfileController::class, 'editProfile'])->name('user.profile.edit');
Route::post('/profile/update', [ProfileController::class, 'updateProfile'])->name('user.profile.update');
Route::resource('auction_categories', AuctionCategoryController::class);
Route::resource('faq_questions', FaqQuestionController::class);
Route::resource('testimonies', TestimonyController::class);
Route::resource('auctions', AuctionController::class);
Route::resource('content-pages', ContentPageController::class);
Route::resource('master-settings', MasterSettingController::class);
Route::resource('createletters', CreateLetterController::class);
Route::resource('transactions', TransactionController::class);
Route::resource('emailtemplates', EmailTemplateController::class);

Route::get('/get-subcategories/{parent}', [AuctionCategoryController::class, 'getSubCategories']);
Route::get('/get-childcategories/{sub}', [AuctionCategoryController::class, 'getChildCategories']);

// Route::get('/test-mail', function () {
//     try {
//         Mail::raw('This is a test email from XpertBid.', function ($message) {
//             $message->to('connecttoabdulrehman01@gmail.com')
//                     ->subject('Test Email from XpertBid');
//         });
//         return 'Test mail sent successfully!';
//     } catch (\Exception $e) {
//         return 'Mail send failed: ' . $e->getMessage();
//     }
// });


 Route::get('/test-new-listing-notification', function () {
     $firstName = 'Ali'; // Test user ka naam
     $listingTitle = 'Sample Auction Listing'; // Test listing ka title
     $auctionEnds = \Carbon\Carbon::now()->addDays(3)->toDayDateTimeString(); // Auction end date ko 3 din baad set karta hai

     try {
         Mail::to('connecttoabdulrehman01@gmail.com')->send(new \App\Mail\NewListingNotification($firstName, $listingTitle, $auctionEnds));
         return 'Test New Listing Notification email sent successfully!';
     } catch (\Exception $e) {
         return 'Mail send failed: ' . $e->getMessage();
     }
});
Route::prefix('locations')->group(function () {
    Route::get('/', [LocationController::class, 'index'])->name('locations.index');
    Route::get('/create', [LocationController::class, 'create'])->name('locations.create');
    Route::post('/', [LocationController::class, 'store'])->name('locations.store');
    Route::get('/{id}/{type}/edit', [LocationController::class, 'edit'])->name('locations.edit');
    Route::put('/{id}/{type}', [LocationController::class, 'update'])->name('locations.update');
    Route::delete('/{id}/{type}', [LocationController::class, 'destroy'])->name('locations.destroy');
});
});


require __DIR__.'/auth.php';
