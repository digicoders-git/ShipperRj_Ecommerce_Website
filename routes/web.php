<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

// Frontend Controllers
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\SellerInquiryController;
use App\Http\Controllers\SocialAuthController;
use App\Http\Controllers\WalletController;
use App\Http\Controllers\ProductReviewController;
use App\Http\Controllers\ComplaintController;
use App\Http\Controllers\SupportController;
use App\Http\Controllers\PushNotificationController;

// Admin Controllers
use App\Http\Controllers\Admin\AdminPushNotificationController;
use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\SubCategoryController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\OfferController;
use App\Http\Controllers\Admin\CouponController as AdminCouponController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\ComplaintController as AdminComplaintController;
use App\Http\Controllers\Admin\ContactController as AdminContactController;
use App\Http\Controllers\Admin\OrderTrackingController as AdminOrderTrackingController;
use App\Http\Controllers\Admin\RefundController as AdminRefundController;
use App\Http\Controllers\Admin\SellerInquiryController as AdminSellerInquiryController;
use App\Http\Controllers\Admin\FaqController as AdminFaqController;
use App\Http\Controllers\Admin\HomeSliderController;
use App\Http\Controllers\Admin\SubAdminController;
use App\Http\Controllers\Admin\WalletOfferController;
use App\Http\Controllers\Admin\SupportTicketController;
use App\Http\Controllers\Admin\ProductReviewController as AdminProductReviewController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\AdminProfileController;
use App\Http\Controllers\Admin\TransactionController as AdminTransactionController;

// Models
use App\Models\Product;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Offer;
use App\Models\Faq;
use App\Models\HomeSlider;
use App\Models\Cart;
use App\Models\Wishlist;
use App\Models\Complaint;
use App\Models\Contact;

Route::get('/', function () {
    $featured_products = Product::with('subCategory')->where('status', 1)->latest()->take(12)->get();
    $home_categories = Category::withCount('products')->get();
    $home_faqs = Faq::where('status', 1)->orderBy('sort_order', 'asc')->take(6)->get();
    $home_sliders = HomeSlider::where('status', 1)->orderBy('sort_order', 'asc')->get();

    $now = now();
    $activeCategoryOffer = Offer::with('category')
        ->where('status', 1)
        ->where('start_date', '<=', $now)
        ->where('end_date', '>=', $now)
        ->latest()
        ->first();

    return view('home', compact(
        'featured_products',
        'home_categories',
        'home_faqs',
        'home_sliders',
        'activeCategoryOffer'
    ));
});


Route::get('/clear-cache', function () {
    Artisan::call('optimize:clear');
    return 'Cache cleared successfully! You can now go back and try again.';
});

Route::get('/session-check', function () {
    $driver = config('session.driver');
    $fileStatus = 'N/A';
    if ($driver === 'file') {
        $sessionPath = storage_path('framework/sessions');
        $fileStatus = is_writable($sessionPath) ? 'Writable' : 'NOT WRITABLE!';
    }
    $dbStatus = 'N/A';
    if ($driver === 'database') {
        $dbStatus = Schema::hasTable(config('session.table')) ? 'Table Exists' : 'TABLE MISSING!';
    }
    session()->put('test_key', 'Session is working correctly!');
    return response()->json([
        'driver' => $driver,
        'file_writable' => $fileStatus,
        'db_table_status' => $dbStatus,
        'secure_cookie' => config('session.secure'),
        'app_url' => config('app.url'),
        'request_scheme' => request()->getScheme(),
        'message' => 'Step 1 complete. Now open /session-read in your browser to verify.'
    ]);
});

Route::get('/session-read', function () {
    return response()->json([
        'result' => session('test_key', 'FAILED: Session is not saving. CSRF will fail.'),
        'action' => session()->has('test_key') ? 'Everything is fine' : 'Session is breaking!'
    ]);
});

Route::get('/view-logs', function () {
    $path = storage_path('logs/laravel.log');
    if (!file_exists($path)) {
        return 'No logs found!';
    }
    $content = file_get_contents($path);
    return '<pre>' . htmlspecialchars(substr($content, -10000)) . '</pre>';
});

Route::get('/session-debug', function () {
    return response()->json([
        'session_id' => session()->getId(),
        'csrf_token' => csrf_token(),
        'auth_check' => Auth::check(),
        'auth_user' => Auth::user() ? Auth::user()->only(['id', 'name', 'email']) : null,
        'request_cookies' => request()->cookies->all(),
    ]);
});

Route::get('/fresh-csrf', function () {
    return response()->json(['token' => csrf_token()]);
});

Route::get('/fix-sessions-db', function () {
    try {
        DB::statement("ALTER TABLE sessions MODIFY user_id VARCHAR(50) NULL");
        return 'Sessions table altered successfully! user_id is now VARCHAR(50).';
    } catch (\Exception $e) {
        return 'Error: ' . $e->getMessage();
    }
});

// Auth Routes
Route::get('/auth', [AuthController::class, 'showAuthForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/check-auth', [AuthController::class, 'checkAuth'])->name('auth.check');

// Google Socialite Routes
Route::get('/auth/google', [SocialAuthController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('/auth/google/callback', [SocialAuthController::class, 'handleGoogleCallback']);

Route::get('/products', function (Request $request) {
    $query = Product::with('subCategory')->where('status', 1);

    // Filter by Search
    $query->when($request->search, function ($q) use ($request) {
        $q->where(function ($sq) use ($request) {
            $sq->where('name', 'like', '%' . $request->search . '%')
                ->orWhere('description', 'like', '%' . $request->search . '%')
                ->orWhere('tags', 'like', '%' . $request->search . '%');
        });
    });

    // Filter by Category
    $query->when($request->category, function ($q) use ($request) {
        $subCategoryIds = SubCategory::where('category_id', $request->category)->pluck('id');
        $q->whereIn('subcategory_id', $subCategoryIds);
    });

    // Filter by Sub Category
    $query->when($request->sub_category, function ($q) use ($request) {
        $q->where('subcategory_id', $request->sub_category);
    });

    // Filter by Trending / Best Sellers
    if ($request->get('filter') === 'trending') {
        $query->where('trending', 1);
    }

    // Filter by Price
    $query->when($request->min_price, function ($q) use ($request) {
        $q->where('selling_price', '>=', $request->min_price);
    });
    $query->when($request->max_price, function ($q) use ($request) {
        $q->where('selling_price', '<=', $request->max_price);
    });

    // Sorting
    $sort = $request->get('sort', 'newest');
    switch ($sort) {
        case 'price_low':
            $query->orderBy('selling_price', 'asc');
            break;
        case 'price_high':
            $query->orderBy('selling_price', 'desc');
            break;
        case 'newest':
        default:
            $query->latest();
            break;
    }

    $products = $query->paginate(12)->withQueryString();
    $categories = Category::withCount('products')->get();

    $selectedCategory = null;
    $categoryOffer = null;
    if ($request->category) {
        $selectedCategory = Category::find($request->category);
        if ($selectedCategory) {
            $categoryOffer = $selectedCategory->getActiveOffer();
        }
    } else {
        $now = now();
        $categoryOffer = Offer::where('status', 1)
            ->where('start_date', '<=', $now)
            ->where('end_date', '>=', $now)
            ->latest()
            ->first();
        if ($categoryOffer) {
            $selectedCategory = $categoryOffer->category;
        }
    }

    return view('products', compact('products', 'categories', 'selectedCategory', 'categoryOffer'));
})->name('products.index');

Route::get('/product-detail/{slug}', function ($slug) {
    $product = Product::with(['subCategory.category', 'images'])->where('slug', $slug)->firstOrFail();
    return view('product-detail', compact('product'));
});

// Quick View AJAX
Route::get('/product/quickview/{id}', function ($id) {
    $product = Product::with(['subCategory.category', 'images'])->findOrFail($id);
    return response()->json($product);
});

// Web Push Notification Public Endpoints
Route::get('/push-public-key', [PushNotificationController::class, 'getPublicKey'])->name('push.key');
Route::post('/push-subscribe', [PushNotificationController::class, 'subscribe'])->name('push.subscribe');
Route::post('/push-unsubscribe', [PushNotificationController::class, 'unsubscribe'])->name('push.unsubscribe');
Route::post('/push-test', [PushNotificationController::class, 'sendTestNotification'])->name('push.test');

// Protected User Routes
Route::middleware(['auth', 'check.blocked'])->group(function () {
    Route::get('/cart', function () {
        $cartItems = Cart::with('product')->where('user_id', Auth::id())->get();
        return view('cart', compact('cartItems'));
    });

    Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
    Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
    Route::post('/cart/update/{id}', [CartController::class, 'update']);
    Route::post('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');

    Route::get('/wishlist', function () {
        $wishlistItems = Wishlist::with('product')->where('user_id', Auth::id())->get();
        return view('wishlist', compact('wishlistItems'));
    });

    Route::post('/wishlist/add/{id}', [WishlistController::class, 'add'])->name('wishlist.add');
    Route::post('/wishlist/remove/{id}', [WishlistController::class, 'remove'])->name('wishlist.remove');

    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
    Route::get('/checkout/payment/{order_id}', [CheckoutController::class, 'paymentPage'])->name('checkout.payment');
    Route::post('/checkout/apply-coupon', [CheckoutController::class, 'applyCoupon'])->name('checkout.applyCoupon');
    Route::post('/checkout/coupon/check', [CheckoutController::class, 'applyCoupon'])->name('checkout.coupon.check');
    Route::post('/checkout/remove-coupon', [CheckoutController::class, 'removeCoupon'])->name('checkout.removeCoupon');
    Route::post('/checkout/process', [CheckoutController::class, 'processOrder'])->name('checkout.process');
    Route::post('/checkout/order/process', [CheckoutController::class, 'processOrder'])->name('checkout.order.process');
    Route::post('/checkout/payment/wallet', [CheckoutController::class, 'payByWallet'])->name('checkout.payment.wallet');
    Route::get('/checkout/cashfree-return', [CheckoutController::class, 'cashfreeCallback'])->name('checkout.cashfreeReturn');
    Route::get('/checkout/cashfree-callback', [CheckoutController::class, 'cashfreeCallback'])->name('checkout.payment.cashfree.callback');

    Route::get('/addresses', [AddressController::class, 'index'])->name('addresses.index');
    Route::post('/address/store', [AddressController::class, 'store'])->name('address.store');
    Route::post('/address/store-alias', [AddressController::class, 'store'])->name('addresses.store');
    Route::post('/address/save', [AddressController::class, 'store'])->name('checkout.address.save');
    Route::post('/address/default/{id}', [AddressController::class, 'setDefault'])->name('address.default');
    Route::post('/address/default-alias/{id}', [AddressController::class, 'setDefault'])->name('addresses.set-default');
    Route::delete('/address/delete/{id}', [AddressController::class, 'destroy'])->name('address.delete');
    Route::delete('/address/delete-alias/{id}', [AddressController::class, 'destroy'])->name('addresses.destroy');

    Route::get('/dashboard', [ProfileController::class, 'dashboard'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'profile'])->name('profile');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
    Route::post('/profile/delete', [ProfileController::class, 'destroy'])->name('profile.delete');

    Route::get('/wallet', [WalletController::class, 'index'])->name('wallet');
    Route::post('/wallet/add', [WalletController::class, 'initiate'])->name('wallet.add');
    Route::post('/wallet/verify', [WalletController::class, 'verify'])->name('wallet.verify');

    Route::get('/orders', [ProfileController::class, 'orders'])->name('orders');
    Route::get('/orders/{order_number}/track', [ProfileController::class, 'trackOrder'])->name('orders.track');
    Route::get('/orders/{id}/invoice', [CheckoutController::class, 'downloadInvoice'])->name('order.invoice');
    Route::post('/orders/{id}/cancel', [ProfileController::class, 'cancelOrder'])->name('orders.cancel');
    Route::post('/orders/{id}/return', [ProfileController::class, 'returnOrder'])->name('orders.return');

    Route::get('/order-success', function () {
        return view('order-success');
    });

    Route::post('/product/review', [ProductReviewController::class, 'store'])->name('product.review.store');
    Route::post('/complaint', [ComplaintController::class, 'store'])->name('complaints.store');

    Route::get('/helpdesk', function () {
        $user_id = Auth::id();
        $deliveredProducts = Product::whereHas('orderItems.order', function ($query) use ($user_id) {
            $query->where('user_id', $user_id)->where('order_status', 'delivered');
        })->get();
        $userComplaints = Complaint::with('product')->where('user_id', $user_id)->latest()->get();

        return view('helpdesk', compact('deliveredProducts', 'userComplaints'));
    });
});

Route::post('/contact', function (Request $request) {
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'phone' => ['required', 'regex:/^[6789]\d{9}$/'],
        'subject' => 'nullable|string|max:255',
        'message' => 'required|string',
    ], [
        'phone.regex' => 'Mobile number must start with 6, 7, 8, or 9 and must be exactly 10 digits.',
        'phone.required' => 'Please enter your mobile number.'
    ]);
    Contact::create($request->all());
    return response()->json(['success' => 'Your message has been sent successfully!']);
})->name('contact.submit');

Route::post('/support/submit', [SupportController::class, 'store'])->name('support.submit');

Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');

Route::get('/privacy', function () {
    return view('privacy');
});

Route::get('/terms', function () {
    return view('terms');
});

Route::get('/faqs', function () {
    $faqs = Faq::where('status', 1)->orderBy('sort_order', 'asc')->get();
    return view('faqs', compact('faqs'));
})->name('faqs');

Route::get('/become-a-seller', [SellerInquiryController::class, 'index'])->name('seller.inquiry');
Route::post('/become-a-seller', [SellerInquiryController::class, 'submit'])->name('seller.inquiry.submit');

Route::get('/refund-policy', function () {
    return view('refund-policy');
});

// Admin & Sub-Admin Auth Routes
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('login.submit');
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');
});

// Sub-Admin Specific Login redirected to unified login
Route::get('/subadmin/login', function () {
    return redirect()->route('admin.login');
})->name('admin.subadmin.login');

// Protected Admin Panel Routes
Route::prefix('admin')->name('admin.')->middleware('admin.auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('/categories', CategoryController::class);
    Route::resource('/sub-categories', SubCategoryController::class);
    Route::resource('/products', AdminProductController::class);
    Route::post('/products/delete-gallery-image/{id}', [AdminProductController::class, 'deleteGalleryImage'])->name('products.deleteGalleryImage');

    Route::resource('/offers', OfferController::class);
    Route::resource('/coupons', AdminCouponController::class);
    Route::post('/coupons/{id}/toggle-visibility', [AdminCouponController::class, 'toggleVisibility'])->name('coupons.toggle-visibility');
    Route::get('/orders/{id}/invoice', [AdminOrderController::class, 'downloadInvoice'])->name('orders.invoice');
    Route::get('/pending-payments', [AdminOrderController::class, 'pendingPayments'])->name('pending-payments.index');
    Route::resource('/orders', AdminOrderController::class);
    Route::get('/customer-carts', [AdminUserController::class, 'userCarts'])->name('user-carts.index');
    Route::delete('/customer-carts/{id}', [AdminUserController::class, 'clearUserCart'])->name('user-carts.clear');
    Route::resource('/users', AdminUserController::class);
    Route::post('/users/{id}/toggle-block', [AdminUserController::class, 'toggleBlock'])->name('users.toggle-block');
    Route::post('/users/{id}/adjust-wallet', [AdminUserController::class, 'adjustWallet'])->name('users.adjust-wallet');
    Route::post('/users/{id}/reset-password', [AdminUserController::class, 'resetPassword'])->name('users.reset-password');
    Route::resource('/complaints', AdminComplaintController::class);
    Route::resource('/contacts', AdminContactController::class);
    Route::resource('/order-tracking', AdminOrderTrackingController::class);
    Route::resource('/refunds', AdminRefundController::class);
    Route::resource('/seller-inquiries', AdminSellerInquiryController::class);
    Route::resource('/faqs', AdminFaqController::class);
    Route::resource('/home-sliders', HomeSliderController::class);

    // Sub-Admin Management
    Route::post('/sub-admins/{subadmin}/toggle-status', [SubAdminController::class, 'toggleStatus'])->name('subadmins.toggle-status');
    Route::resource('/sub-admins', SubAdminController::class)->names([
        'index' => 'subadmins.index',
        'create' => 'subadmins.create',
        'store' => 'subadmins.store',
        'edit' => 'subadmins.edit',
        'update' => 'subadmins.update',
        'destroy' => 'subadmins.destroy'
    ])->parameters([
                'sub-admins' => 'subadmin'
            ]);

    Route::resource('/wallet-offers', WalletOfferController::class);
    Route::resource('/support-tickets', SupportTicketController::class);
    Route::resource('/reviews', AdminProductReviewController::class)->only(['index', 'update', 'destroy']);

    // Additional settings and profile
    Route::get('/global-settings', [SettingsController::class, 'index'])->name('settings');
    Route::post('/global-settings', [SettingsController::class, 'store'])->name('settings.store');
    Route::post('/global-settings/delete-tier', [SettingsController::class, 'deleteTier'])->name('settings.deleteTier');

    Route::get('/profile', [AdminProfileController::class, 'index'])->name('profile');
    Route::put('/profile', [AdminProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [AdminProfileController::class, 'updatePassword'])->name('profile.password');

    Route::get('/transactions', [AdminTransactionController::class, 'index'])->name('transactions.index');

    // Web Push Notification Admin Management
    Route::get('/push-notifications', [AdminPushNotificationController::class, 'index'])->name('push.index');
    Route::post('/push-notifications/broadcast', [AdminPushNotificationController::class, 'sendBroadcast'])->name('push.broadcast');
});
