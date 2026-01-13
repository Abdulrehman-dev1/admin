<?php
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\TrackingController;
use App\Http\Controllers\CargoTypeController;
use App\Http\Controllers\RoleController;
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
use App\Http\Controllers\BidController;
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
use App\Http\Controllers\BuyNowInquiryController;
use App\Models\IndividualVerification;
use App\Mail\VerificationDeclinedMail;

use App\Http\Controllers\ScraperController;
use App\Http\Controllers\OlxScraperController;
use App\Http\Controllers\PaymentVerificationController;
use App\Http\Controllers\OrderController;


use Illuminate\Support\Facades\Mail;

Route::get('/send-test-mail', function () {
    try {
        Mail::raw('Hello! This is a test email from Localhost via Gmail SMTP.', function ($message) {
            $message->to('connecttoabdulrehman01@gmail.com') // Jisko bhejni hai uska email
                ->subject('Localhost SMTP Test');
        });
        return 'Email has been sent successfully!';
    } catch (\Exception $e) {
        return 'Error: ' . $e->getMessage();
    }
});


Route::get('/scraper', [ScraperController::class, 'index'])->name('scraper.index')->middleware('permission:scraper-list');
Route::post('/scraper/preview', [ScraperController::class, 'preview'])->name('scraper.preview')->middleware('permission:scraper-list');
Route::post('/scraper/save', [ScraperController::class, 'save'])->name('scraper.save')->middleware('permission:scraper-list');

// OLX Scraper Routes
Route::get('/olx-scraper', [OlxScraperController::class, 'index'])->name('olx-scraper.index')->middleware('permission:olx-scraper-list');
Route::post('/olx-scraper/preview', [OlxScraperController::class, 'preview'])->name('olx-scraper.preview')->middleware('permission:olx-scraper-list');
Route::post('/olx-scraper/save', [OlxScraperController::class, 'save'])->name('olx-scraper.save')->middleware('permission:olx-scraper-list');

// routes/web.php
Route::middleware(['auth'])->group(function () {
    Route::resource('blogs', BlogController::class)->middleware('permission:blog-list');
});


Route::prefix('referrals')->middleware('permission:referral-list')->group(function () {
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
Route::post(
    'vehicle-verifications/{vehicleVerification}/accept',
    [VehicleVerificationController::class, 'accept']
)
    ->name('vehicle-verifications.accept');
Route::post(
    'vehicle-verifications/{vehicleVerification}/decline',
    [VehicleVerificationController::class, 'decline']
)
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


Route::middleware(['auth', 'permission:corporate-verification-list'])->group(function () {
    // Resource routes for index, create, store, show, edit, update, destroy
    Route::resource('corporate-verifications', CorporateVerificationController::class)
        ->names('corporate-verifications');

    // Custom Accept / Decline actions
    Route::post(
        'corporate-verifications/{corporate_verification}/accept',
        [CorporateVerificationController::class, 'accept']
    )
        ->name('corporate-verifications.accept');

    Route::post(
        'corporate-verifications/{corporate_verification}/decline',
        [CorporateVerificationController::class, 'decline']
    )
        ->name('corporate-verifications.decline');
});

Route::get('/debug-perms', function () {
    app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
    $user = auth()->user();
    if (!$user)
        return 'Not logged in';

    // Auto-fix: If user has roles but NO permissions, assign default ones to the role
    if ($user->roles->count() > 0 && $user->getAllPermissions()->isEmpty()) {
        $role = $user->roles->first();
        // Give basic permissions to see the panel
        $permissions = \Spatie\Permission\Models\Permission::whereIn('name', [
            'role-list',
            'role-edit',
            'user-list',
            'permission-list'
        ])->get();
        if ($role && $permissions->count() > 0) {
            $role->syncPermissions($permissions);
            // Clear cache again after update
            app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
            $user->refresh();
        }
    }

    return [
        'user' => $user->name,
        'roles' => $user->getRoleNames(),
        'permissions' => $user->getAllPermissions()->pluck('name'),
        'can_user_list' => $user->can('user-list'),
        'can_role_list' => $user->can('role-list'),
        'status' => 'Permissions attempt-fixed if they were empty.',
    ];
});

Route::get('/debug-permissions-list', function () {
    $permissions = \Spatie\Permission\Models\Permission::all(['id', 'name']);
    return [
        'total' => $permissions->count(),
        'permissions' => $permissions->toArray()
    ];
});

Route::get('/fix-admin-role', function () {
    $adminUsers = \App\Models\User::where('role', 'admin')->get();
    $adminRole = \Spatie\Permission\Models\Role::where('name', 'admin')->first();

    foreach ($adminUsers as $user) {
        $user->syncRoles(['admin']);
    }

    app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

    return [
        'message' => 'Admin role assigned to ' . $adminUsers->count() . ' users',
        'users' => $adminUsers->pluck('name', 'email')
    ];
});

Route::get('/clean-invalid-permissions', function () {
    $validPermissionIds = \Spatie\Permission\Models\Permission::pluck('id')->toArray();
    $roles = \Spatie\Permission\Models\Role::all();

    foreach ($roles as $role) {
        $currentPermissions = $role->permissions->pluck('id')->toArray();
        $invalidPermissions = array_diff($currentPermissions, $validPermissionIds);

        if (count($invalidPermissions) > 0) {
            // Remove invalid permissions
            \DB::table('role_has_permissions')
                ->where('role_id', $role->id)
                ->whereIn('permission_id', $invalidPermissions)
                ->delete();
        }
    }

    app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

    return ['message' => 'Invalid permissions cleaned from all roles'];
});

Route::get('/fix-bids-permission', function () {
    try {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $permission = \Spatie\Permission\Models\Permission::firstOrCreate(['name' => 'bid-list']);
        $adminRole = \Spatie\Permission\Models\Role::where('name', 'admin')->first();

        if ($adminRole) {
            $adminRole->givePermissionTo($permission);
            return 'Permission "bid-list" created and assigned to "admin" role. Please visit the Bids tab now.';
        }

        return 'Admin role not found.';
    } catch (\Exception $e) {
        return 'Error: ' . $e->getMessage();
    }
});

Route::middleware(['auth'])->group(function () {
    // Resource routes for index, create, store, show, edit, update, destroy
    Route::resource(
        'individual-verifications',
        IndividualVerificationController::class
    )->middleware('permission:individual-verification-list');
    Route::get('payment-requests-admin', [App\Http\Controllers\PaymentRequestController::class, 'Adminindex'])
        ->name('payment-requests-admin')->middleware('permission:payment-request-list');
    Route::get('wallets', [WalletController::class, 'index'])
        ->name('wallets.index')->middleware('permission:wallet-list');
    Route::put('wallets/{wallet}', [WalletController::class, 'update'])
        ->name('wallets.update')->middleware('permission:wallet-list');
    Route::put(
        'payment-requests/{payment_request}',
        [PaymentRequestController::class, 'update']
    )->name('payment-requests.update')->middleware('permission:payment-request-list');

    // Payment Verification Routes
    Route::middleware('permission:payment-verification-list')->group(function () {
        Route::get('payment-verifications', [PaymentVerificationController::class, 'index'])
            ->name('payment-verifications.index');
        Route::get('payment-verifications/{id}', [PaymentVerificationController::class, 'show'])
            ->name('payment-verifications.show');
        Route::post('payment-verifications/{id}/approve', [PaymentVerificationController::class, 'approve'])
            ->name('payment-verifications.approve');
        Route::post('payment-verifications/{id}/decline', [PaymentVerificationController::class, 'decline'])
            ->name('payment-verifications.decline');
    });
    // Receipt image route
    Route::get('receipts/{filename}', [PaymentVerificationController::class, 'receipt'])
        ->name('receipts.show')
        ->where('filename', '[A-Za-z0-9._-]+');

    // Orders Routes
    Route::middleware('permission:order-list')->group(function () {
        Route::get('orders', [OrderController::class, 'index'])
            ->name('orders.index');
        Route::get('orders/{id}', [OrderController::class, 'show'])
            ->name('orders.show');
        Route::put('orders/{id}/update-status', [OrderController::class, 'updateStatus'])
            ->name('orders.update-status');
    });
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
Route::post(
    'individual-verifications/{id}/accept',
    [IndividualVerificationController::class, 'accept']
)
    ->name('individual-verifications.accept')
    ->middleware('auth');

// Decline
Route::post(
    'individual-verifications/{id}/decline',
    [IndividualVerificationController::class, 'decline']
)
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
    ->only(['index', 'edit', 'update'])->middleware('permission:auction-verification-list');

Route::prefix('admin')
    ->middleware('auth')
    ->group(function () {
        Route::resource('seo', SeoController::class)->middleware('permission:seo-list'); //  use the imported class
    });



Route::middleware(['auth', 'permission:dashboard-list'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])
        ->name('dashboard');
    Route::get('/graph-data', [DashboardController::class, 'getGraphData'])
        ->name('dashboard.graph-data');
    // any other routes behind the login wall…
});
Route::get('/promotions', [PromotionController::class, 'index'])
    ->name('promotions.index')->middleware('permission:promotion-list');


Route::get('/slider-categories/create', [SliderCategoryController::class, 'create'])->name('slider_categories.create');
Route::post('/slider-categories', [SliderCategoryController::class, 'store'])->name('slider_categories.store');

Route::prefix('admin')->middleware('permission:identity-list')->group(function () {
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

Route::resource('sliders', SliderController::class)->middleware('permission:slider-list');

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
    Route::resource('roles', RoleController::class)->middleware('permission:role-list');
    Route::get('users/{user}/roles', [RoleController::class, 'assignRoleForm'])->name('users.roles')->middleware('permission:role-edit');
    Route::post('users/{user}/roles', [RoleController::class, 'assignRole'])->name('users.roles.store')->middleware('permission:role-edit');
    Route::resource('permissions', PermissionsController::class)->middleware('permission:permission-list');
    Route::get('/get-subcategories/{id}', [AuctionCategoryController::class, 'getSubcategories']);
    Route::get('/get-children/{id}', [AuctionCategoryController::class, 'getChildern']);
    Route::get('utm-campaign-users', [UserController::class, 'utmCampaign'])->name('utm_campaign_users.index')->middleware('permission:user-list');
    Route::get('users/export', [UserController::class, 'export'])->name('users.export');
    Route::resource('users', UserController::class)->middleware('permission:user-list');
    Route::post('users/{user}/update-status', [UserController::class, 'updateStatus'])->name('users.updateStatus');
    Route::get('/profile', [UserController::class, 'show'])->name('user.profile');
    Route::get('/profile/edit', [ProfileController::class, 'editProfile'])->name('user.profile.edit');
    Route::post('/profile/update', [ProfileController::class, 'updateProfile'])->name('user.profile.update');
    Route::resource('auction_categories', AuctionCategoryController::class)->middleware('permission:category-list');
    Route::resource('faq_questions', FaqQuestionController::class);
    Route::resource('testimonies', TestimonyController::class);
    Route::resource('auctions', AuctionController::class)->middleware('permission:auction-list');
    Route::resource('content-pages', ContentPageController::class);
    Route::resource('master-settings', MasterSettingController::class);
    Route::resource('createletters', CreateLetterController::class);
    Route::resource('transactions', TransactionController::class)->middleware('permission:transaction-list');
    Route::resource('emailtemplates', EmailTemplateController::class);
    Route::middleware('permission:buy-now-inquiry-list')->group(function () {
        Route::get('buy-now-inquiries', [BuyNowInquiryController::class, 'index'])->name('buy-now-inquiries.index');
        Route::get('buy-now-inquiries/{id}', [BuyNowInquiryController::class, 'show'])->name('buy-now-inquiries.show');
        Route::post('buy-now-inquiries/{id}/update-status', [BuyNowInquiryController::class, 'updateStatus'])->name('buy-now-inquiries.update-status');
        Route::delete('buy-now-inquiries/{id}', [BuyNowInquiryController::class, 'destroy'])->name('buy-now-inquiries.destroy');
    });

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

    Route::get('bids', [BidController::class, 'index'])->name('bids.index');
    Route::get('bids/{id}', [BidController::class, 'show'])->name('bids.show');
    Route::get('email-logs', [App\Http\Controllers\Admin\EmailLogController::class, 'index'])->name('email-logs.index');

});


require __DIR__ . '/auth.php';
