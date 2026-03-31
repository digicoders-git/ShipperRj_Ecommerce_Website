<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\AddressController;

Route::get('/', function () {
    $featured_products = \App\Models\Product::with('subCategory')->where('status', 1)->latest()->take(12)->get();
    $home_categories = \App\Models\Category::withCount('subCategories')->get();
    return view('home', compact('featured_products', 'home_categories'));
});

// Auth Routes
Route::get('/auth', [AuthController::class, 'showAuthForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/check-auth', [AuthController::class, 'checkAuth'])->name('auth.check');

// Google Socialite Routes
Route::get('/auth/google', [\App\Http\Controllers\SocialAuthController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('/auth/google/callback', [\App\Http\Controllers\SocialAuthController::class, 'handleGoogleCallback']);

Route::get('/products', function (Illuminate\Http\Request $request) {
    $query = \App\Models\Product::with('subCategory')->where('status', 1);

    // Filter by Category
    if ($request->filled('category')) {
        $query->whereHas('subCategory', function ($q) use ($request) {
            $q->where('category_id', $request->category);
        });
    }

    // Filter by Trending / Best Sellers
    if ($request->get('filter') === 'trending') {
        $query->where('trending', 1);
    }

    // Filter by Price
    if ($request->filled('min_price')) {
        $query->where('selling_price', '>=', $request->min_price);
    }
    if ($request->filled('max_price')) {
        $query->where('selling_price', '<=', $request->max_price);
    }

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
    $categories = \App\Models\Category::withCount('products')->get();

    return view('products', compact('products', 'categories'));
})->name('products.index');

Route::get('/product-detail/{slug}', function ($slug) {
    $product = \App\Models\Product::with(['subCategory.category', 'images'])->where('slug', $slug)->firstOrFail();
    return view('product-detail', compact('product'));
});

// Quick View AJAX
Route::get('/product/quickview/{id}', function ($id) {
    $product = \App\Models\Product::with(['subCategory.category', 'images'])->findOrFail($id);
    return response()->json($product);
});

// Protected User Routes
Route::middleware(['auth', 'check.blocked'])->group(function () {
    Route::get('/cart', function () {
        $cartItems = \App\Models\Cart::with('product')->where('user_id', \Illuminate\Support\Facades\Auth::id())->get();
        return view('cart', compact('cartItems'));
    });

    Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
    Route::post('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
    Route::post('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');

    Route::get('/wishlist', function () {
        $wishlistItems = \App\Models\Wishlist::with('product')->where('user_id', \Illuminate\Support\Facades\Auth::id())->get();
        return view('wishlist', compact('wishlistItems'));
    });

    Route::post('/wishlist/add/{id}', [WishlistController::class, 'add'])->name('wishlist.add');
    Route::post('/wishlist/remove/{id}', [WishlistController::class, 'remove'])->name('wishlist.remove');

    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout/address/save', [CheckoutController::class, 'saveAddress'])->name('checkout.address.save');
    Route::post('/checkout/address/select', [CheckoutController::class, 'selectAddress'])->name('checkout.address.select');
    Route::post('/checkout/process', [CheckoutController::class, 'processOrder'])->name('checkout.order.process');
    Route::post('/checkout/coupon/check', [CheckoutController::class, 'checkCoupon'])->name('checkout.coupon.check');
    Route::get('/checkout/payment/{order_id}', [CheckoutController::class, 'paymentPage'])->name('checkout.payment');
    Route::post('/checkout/payment/verify', [CheckoutController::class, 'verifyPayment'])->name('checkout.payment.verify');
    Route::post('/checkout/payment/wallet', [CheckoutController::class, 'payByWallet'])->name('checkout.payment.wallet');
    Route::get('/order/invoice/{order_id}', [CheckoutController::class, 'downloadInvoice'])->name('order.invoice');

    // Address Management Routes
    Route::get('/addresses', [AddressController::class, 'index'])->name('addresses.index');
    Route::post('/addresses/store', [AddressController::class, 'store'])->name('addresses.store');
    Route::post('/addresses/update/{id}', [AddressController::class, 'update'])->name('addresses.update');
    Route::delete('/addresses/delete/{id}', [AddressController::class, 'destroy'])->name('addresses.destroy');
    Route::post('/addresses/set-default/{id}', [AddressController::class, 'setDefault'])->name('addresses.set-default');

    Route::get('/dashboard', [ProfileController::class, 'dashboard'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'profile'])->name('profile');

    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');

    Route::get('/wallet', [App\Http\Controllers\WalletController::class, 'index'])->name('wallet');
    Route::post('/wallet/add', [App\Http\Controllers\WalletController::class, 'initiate'])->name('wallet.add');
    Route::post('/wallet/verify', [App\Http\Controllers\WalletController::class, 'verify'])->name('wallet.verify');

    Route::get('/orders', [ProfileController::class, 'orders'])->name('orders');
    Route::get('/orders/{order_number}/track', [ProfileController::class, 'trackOrder'])->name('orders.track');
    Route::post('/orders/{id}/cancel', [ProfileController::class, 'cancelOrder'])->name('orders.cancel');
    Route::post('/orders/{id}/return', [ProfileController::class, 'returnOrder'])->name('orders.return');

    Route::get('/order-success', function () {
        return view('order-success');
    });

    Route::post('/product/review', [App\Http\Controllers\ProductReviewController::class, 'store'])->name('product.review.store');
    Route::post('/complaint', [App\Http\Controllers\ComplaintController::class, 'store'])->name('complaints.store');
});

Route::post('/contact', function (Illuminate\Http\Request $request) {
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
    \App\Models\Contact::create($request->all());
    return response()->json(['success' => 'Your message has been sent successfully!']);
})->name('contact.submit');

Route::post('/support/submit', [App\Http\Controllers\SupportController::class, 'store'])->name('support.submit');

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

Route::get('/refund-policy', function () {
    return view('refund-policy');
});

Route::get('/helpdesk', function () {
    $deliveredProducts = collect();
    $userComplaints = collect();
    if (Illuminate\Support\Facades\Auth::check()) {
        $user_id = Illuminate\Support\Facades\Auth::id();
        $deliveredProducts = \App\Models\Product::whereHas('orderItems.order', function ($query) use ($user_id) {
            $query->where('user_id', $user_id)->where('order_status', 'delivered');
        })->get();
        $userComplaints = \App\Models\Complaint::with('product')->where('user_id', $user_id)->latest()->get();
    }
    return view('helpdesk', compact('deliveredProducts', 'userComplaints'));
});

// Admin & Sub-Admin Auth Routes
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [App\Http\Controllers\Admin\AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [App\Http\Controllers\Admin\AuthController::class, 'login'])->name('login.submit');

    // Sub-Admin Specific Login
    Route::get('/subadmin/login', [App\Http\Controllers\Admin\SubAdminController::class, 'showLogin'])->name('subadmin.login');
    Route::post('/subadmin/login', [App\Http\Controllers\Admin\SubAdminController::class, 'login'])->name('subadmin.login.submit');

    Route::post('/logout', [App\Http\Controllers\Admin\AuthController::class, 'logout'])->name('logout');
});

// Protected Admin Panel Routes
Route::prefix('admin')->name('admin.')->middleware('admin.auth')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
    Route::resource('/categories', App\Http\Controllers\Admin\CategoryController::class);
    Route::resource('/sub-categories', App\Http\Controllers\Admin\SubCategoryController::class);
    Route::resource('/products', App\Http\Controllers\Admin\ProductController::class);
    Route::post('/products/delete-gallery-image/{id}', [App\Http\Controllers\Admin\ProductController::class, 'deleteGalleryImage'])->name('products.deleteGalleryImage');

    Route::resource('/offers', App\Http\Controllers\Admin\OfferController::class);
    Route::resource('/coupons', App\Http\Controllers\Admin\CouponController::class);
    Route::get('/orders/{id}/invoice', [App\Http\Controllers\Admin\OrderController::class, 'downloadInvoice'])->name('orders.invoice');
    Route::resource('/orders', App\Http\Controllers\Admin\OrderController::class);
    Route::resource('/users', App\Http\Controllers\Admin\UserController::class);
    Route::post('/users/{id}/toggle-block', [App\Http\Controllers\Admin\UserController::class, 'toggleBlock'])->name('users.toggle-block');
    Route::resource('/complaints', App\Http\Controllers\Admin\ComplaintController::class);
    Route::resource('/contacts', App\Http\Controllers\Admin\ContactController::class);
    Route::resource('/order-tracking', App\Http\Controllers\Admin\OrderTrackingController::class);
    Route::resource('/refunds', App\Http\Controllers\Admin\RefundController::class);

    // Sub-Admin Management (Crucial)
    Route::post('/sub-admins/{subadmin}/toggle-status', [App\Http\Controllers\Admin\SubAdminController::class, 'toggleStatus'])->name('subadmins.toggle-status');
    Route::resource('/sub-admins', App\Http\Controllers\Admin\SubAdminController::class)->names([
        'index' => 'subadmins.index',
        'create' => 'subadmins.create',
        'store' => 'subadmins.store',
        'edit' => 'subadmins.edit',
        'update' => 'subadmins.update',
        'destroy' => 'subadmins.destroy'
    ])->parameters([
                'sub-admins' => 'subadmin'
            ]);

    Route::resource('/wallet-offers', App\Http\Controllers\Admin\WalletOfferController::class);
    Route::resource('/support-tickets', App\Http\Controllers\Admin\SupportTicketController::class);
    Route::resource('/reviews', App\Http\Controllers\Admin\ProductReviewController::class)->only(['index', 'update', 'destroy']);

    // Additional settings and profile
    Route::get('/global-settings', [App\Http\Controllers\Admin\SettingsController::class, 'index'])->name('settings');
    Route::post('/global-settings', [App\Http\Controllers\Admin\SettingsController::class, 'store'])->name('settings.store');

    Route::get('/profile', [App\Http\Controllers\Admin\AdminProfileController::class, 'index'])->name('profile');
    Route::put('/profile', [App\Http\Controllers\Admin\AdminProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [App\Http\Controllers\Admin\AdminProfileController::class, 'updatePassword'])->name('profile.password');

    Route::get('/transactions', [App\Http\Controllers\Admin\TransactionController::class, 'index'])->name('transactions.index');
});
