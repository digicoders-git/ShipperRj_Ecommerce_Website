@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('admin_content')
    <div class="mb-5 d-flex justify-content-between align-items-end flex-wrap gap-3">
        <div>
            <h3 class="fw-black mb-1 text-dark d-flex align-items-center gap-2" style="letter-spacing: -1px;">
                <div class="text-primary rounded p-2 d-inline-flex" style="background-color: rgba(255, 184, 0, 0.1) !important;">
                    <i class="bi bi-grid-1x2-fill fs-5"></i>
                </div>
                Executive Overview
            </h3>
            <p class="text-secondary small fw-bold mb-0 mt-2">Real-time marketplace insights & system analytics.</p>
        </div>
        <div>
            <button
                class="btn btn-dark btn-sm rounded-pill px-4 py-2 shadow-sm d-flex align-items-center gap-2 fw-bold transition-all hover-translate-y"
                onclick="window.location.reload();">
                <i class="bi bi-arrow-clockwise"></i> Sync Data
            </button>
        </div>
    </div>

    @php
        $isAdmin = auth('admin')->check();
        $subAdmin = auth('subadmin')->user();

        $rev = \App\Models\Order::where('payment_status', 'paid')->sum('total_amount') ?? 0;
        $pending = \App\Models\Order::where('order_status', 'pending')->count() ?? 0;
        $totalSubcategories = \App\Models\SubCategory::count() ?? 0;
        $users = $stats['total_users'] ?? 0;
        $orders = $stats['total_orders'] ?? 0;
        $products = $stats['total_products'] ?? 0;
        $categories = $stats['total_categories'] ?? 0;

        // Dynamic metrics for the sidebar status cards
        $totalCoupons = \App\Models\Coupon::count() ?? 0;
        $totalOffers = \App\Models\Offer::count() ?? 0;
        $totalOffersAndCoupons = $totalCoupons + $totalOffers;
        
        $totalWalletTransactions = \App\Models\WalletTransaction::count() ?? 0;
        $totalOrderPayments = \App\Models\Order::where('payment_status', 'paid')->count() ?? 0;
        $totalTransactions = $totalWalletTransactions + $totalOrderPayments;

        $totalWalletOffers = \App\Models\WalletOffer::count() ?? 0;
        $totalSellerInquiries = \App\Models\SellerInquiry::count() ?? 0;
        $totalComplaints = \App\Models\Complaint::count() ?? 0;
        $totalContacts = \App\Models\Contact::count() ?? 0;
        $totalSupportTickets = \App\Models\SupportTicket::count() ?? 0;
        $totalReviews = \App\Models\ProductReview::count() ?? 0;
        $totalRefunds = \App\Models\Refund::count() ?? 0;
        $totalFaqs = \App\Models\Faq::count() ?? 0;
        $totalSliders = \App\Models\HomeSlider::count() ?? 0;
        $totalSubAdmins = \App\Models\SubAdmin::count() ?? 0;

        // Fetch revenue for last 6 months dynamically
        $months = [];
        $chartData = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $months[] = $date->format('M');
            $chartData[] = \App\Models\Order::where('payment_status', 'paid')
                ->whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->sum('total_amount') ?? 0;
        }

        // Fetch revenue for this year dynamically
        $thisYearMonths = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        $thisYearData = [];
        $currentYear = now()->year;
        for ($m = 1; $m <= 12; $m++) {
            $thisYearData[] = \App\Models\Order::where('payment_status', 'paid')
                ->whereYear('created_at', $currentYear)
                ->whereMonth('created_at', $m)
                ->sum('total_amount') ?? 0;
        }

        // Fetch revenue for all time dynamically (grouped by year)
        $yearsData = \App\Models\Order::where('payment_status', 'paid')
            ->selectRaw('YEAR(created_at) as year, sum(total_amount) as total')
            ->groupBy('year')
            ->orderBy('year', 'asc')
            ->get();
            
        $allTimeLabels = [];
        $allTimeData = [];
        if ($yearsData->isEmpty()) {
            $allTimeLabels = [now()->year];
            $allTimeData = [0];
        } else {
            foreach ($yearsData as $yData) {
                $allTimeLabels[] = (string)$yData->year;
                $allTimeData[] = (float)$yData->total;
            }
        }

        // Fetch order status breakdown dynamically
        $orderStatuses = \App\Models\Order::selectRaw('order_status, count(*) as count')
            ->groupBy('order_status')
            ->get();
            
        $statusLabels = [];
        $statusCounts = [];
        foreach ($orderStatuses as $status) {
            $statusLabels[] = ucfirst(str_replace('_', ' ', $status->order_status ?? 'unknown'));
            $statusCounts[] = (int)$status->count;
        }
    @endphp

    @php
        $showRevenue = $isAdmin || ($subAdmin && $subAdmin->hasPermission('transactions_view'));
        $showOrders = $isAdmin || ($subAdmin && $subAdmin->hasPermission('orders_view'));
        $showUsers = $isAdmin || ($subAdmin && $subAdmin->hasPermission('users_view'));
        $showProducts = $isAdmin || ($subAdmin && $subAdmin->hasPermission('products_view'));
        $showExecutiveOverview = $showRevenue || $showOrders || $showUsers || $showProducts;
    @endphp

    @if($showExecutiveOverview)
    <!-- Executive Status Cards Row -->
    <div class="row g-4 mb-5">
        @if($showRevenue)
        <!-- Revenue Card -->
        <div class="col-sm-6 col-xl-3">
            <a href="{{ route('admin.transactions.index') }}"
                class="card bg-white border-0 rounded-4 p-4 h-100 shadow-sm transition-all hover-shadow-lg position-relative overflow-hidden group border-top border-4 border-success text-decoration-none">
                <div class="position-absolute top-0 end-0 bg-success bg-opacity-10 w-50 h-100"
                    style="border-radius: 100% 0 0 100%; transform: translateX(50%);"></div>

                <div class="d-flex justify-content-between align-items-start mb-4 position-relative z-1">
                    <div class="rounded-circle bg-success bg-opacity-10 text-success d-flex align-items-center justify-content-center"
                        style="width: 50px; height: 50px;">
                        <i class="bi bi-wallet2 fs-4"></i>
                    </div>
                </div>
                <div class="text-secondary x-small fw-bold text-uppercase tracking-widest mb-2 position-relative z-1">Total
                    Revenue</div>
                <h2 class="fw-black mb-0 text-dark position-relative z-1" style="letter-spacing: -1px;">
                    ₹{{ number_format($rev, 2) }}</h2>
            </a>
        </div>
        @endif

        @if($showOrders)
        <!-- Orders Card -->
        <div class="col-sm-6 col-xl-3">
            <a href="{{ route('admin.orders.index') }}"
                class="card bg-white border-0 rounded-4 p-4 h-100 shadow-sm transition-all hover-shadow-lg position-relative overflow-hidden group border-top border-4 border-primary text-decoration-none">
                <div class="position-absolute top-0 end-0 w-50 h-100"
                    style="border-radius: 100% 0 0 100%; transform: translateX(50%); background-color: rgba(255, 122, 24, 0.08) !important;"></div>

                <div class="d-flex justify-content-between align-items-start mb-4 position-relative z-1">
                    <div class="rounded-circle text-primary d-flex align-items-center justify-content-center"
                        style="width: 50px; height: 50px; background-color: rgba(255, 184, 0, 0.1) !important;">
                        <i class="bi bi-bag-check fs-4"></i>
                    </div>
                    @if($pending > 0)
                        <span
                            class="badge bg-warning bg-opacity-10 text-white rounded-pill fw-bold px-3 py-2 x-small border border-warning border-opacity-25 pulse-border"><span
                                class="pulse-dot bg-warning d-inline-block me-2"
                                style="width: 6px; height: 6px; border-radius: 50%;"></span>{{ $pending }} Pending</span>
                    @endif
                </div>
                <div class="text-secondary x-small fw-bold text-uppercase tracking-widest mb-2 position-relative z-1">Total
                    Orders</div>
                <h2 class="fw-black mb-0 text-dark position-relative z-1" style="letter-spacing: -1px;">
                    {{ number_format($orders) }}
                </h2>
            </a>
        </div>
        @endif

        @if($showUsers)
        <!-- Users Card -->
        <div class="col-sm-6 col-xl-3">
            <a href="{{ route('admin.users.index') }}"
                class="card bg-white border-0 rounded-4 p-4 h-100 shadow-sm transition-all hover-shadow-lg position-relative overflow-hidden group border-top border-4 border-danger text-decoration-none">
                <div class="position-absolute top-0 end-0 bg-danger bg-opacity-10 w-50 h-100"
                    style="border-radius: 100% 0 0 100%; transform: translateX(50%);"></div>

                <div class="d-flex justify-content-between align-items-start mb-4 position-relative z-1">
                    <div class="rounded-circle bg-danger bg-opacity-10 text-danger d-flex align-items-center justify-content-center"
                        style="width: 50px; height: 50px;">
                        <i class="bi bi-people fs-4"></i>
                    </div>
                </div>
                <div class="text-secondary x-small fw-bold text-uppercase tracking-widest mb-2 position-relative z-1">Active
                    Users</div>
                <h2 class="fw-black mb-0 text-dark position-relative z-1" style="letter-spacing: -1px;">
                    {{ number_format($users) }}
                </h2>
            </a>
        </div>
        @endif

        @if($showProducts)
        <!-- Inventory Card -->
        <div class="col-sm-6 col-xl-3">
            <a href="{{ route('admin.products.index') }}"
                class="card bg-white border-0 rounded-4 p-4 h-100 shadow-sm transition-all hover-shadow-lg position-relative overflow-hidden group border-top border-4 border-warning text-decoration-none">
                <div class="position-absolute top-0 end-0 bg-warning bg-opacity-10 w-50 h-100"
                    style="border-radius: 100% 0 0 100%; transform: translateX(50%);"></div>

                <div class="d-flex justify-content-between align-items-start mb-4 position-relative z-1">
                    <div class="rounded-circle bg-warning bg-opacity-10 text-warning d-flex align-items-center justify-content-center"
                        style="width: 50px; height: 50px;">
                        <i class="bi bi-box-seam fs-4"></i>
                    </div>
                </div>
                <div class="text-secondary x-small fw-bold text-uppercase tracking-widest mb-2 position-relative z-1">
                    Products Base</div>
                <h2 class="fw-black mb-0 text-dark position-relative z-1" style="letter-spacing: -1px;">
                    {{ number_format($products) }}
                </h2>
            </a>
        </div>
        @endif
    </div>
    @endif

    @php
        $showQuickStats = $isAdmin || ($subAdmin && (
            $subAdmin->hasPermission('categories_view') ||
            $subAdmin->hasPermission('sub_categories_view') ||
            $subAdmin->hasPermission('coupons_view') ||
            $subAdmin->hasPermission('transactions_view') ||
            $subAdmin->hasPermission('wallet_deals_view') ||
            $subAdmin->hasPermission('users_view') ||
            $subAdmin->hasPermission('seller_inquiries_view') ||
            $subAdmin->hasPermission('complaints_view') ||
            $subAdmin->hasPermission('contacts_view') ||
            $subAdmin->hasPermission('support_view') ||
            $subAdmin->hasPermission('reviews_view') ||
            $subAdmin->hasPermission('refunds_view') ||
            $subAdmin->hasPermission('faqs_view') ||
            $subAdmin->hasPermission('home_sliders_view')
        ));
    @endphp

    @if($showQuickStats)
    <!-- Module Status Cards Grid -->
    <div class="mb-4">
        <h4 class="fw-black mb-1 text-dark d-flex align-items-center gap-2" style="letter-spacing: -0.5px;">
            <div class="text-primary rounded p-2 d-inline-flex" style="font-size: 1.1rem; background-color: rgba(255, 184, 0, 0.1) !important;">
                <i class="bi bi-collection"></i>
            </div>
            Module Quick Stats
        </h4>
        <p class="text-secondary small fw-bold mb-0">Navigate to sections and view metrics for all system modules.</p>
    </div>

    <div class="row g-3 mb-5">
        <!-- Categories -->
        @if($isAdmin || ($subAdmin && $subAdmin->hasPermission('categories_view')))
            <div class="col-6 col-sm-4 col-md-3 col-xl-2">
                <a href="{{ route('admin.categories.index') }}"
                    class="card bg-white border-0 rounded-4 p-3 h-100 shadow-sm text-decoration-none transition-all hover-translate-y border-top border-4 border-primary">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <div class="rounded-circle text-primary d-flex align-items-center justify-content-center"
                            style="width: 38px; height: 38px; background-color: rgba(255, 184, 0, 0.1) !important;">
                            <i class="bi bi-grid-3x3-gap fs-5"></i>
                        </div>
                    </div>
                    <div class="text-secondary xx-small fw-bold text-uppercase tracking-widest mb-1 text-truncate">Categories</div>
                    <h4 class="fw-black mb-0 text-dark">{{ number_format($categories) }}</h4>
                </a>
            </div>
        @endif

        <!-- Sub Categories -->
        @if($isAdmin || ($subAdmin && $subAdmin->hasPermission('sub_categories_view')))
            <div class="col-6 col-sm-4 col-md-3 col-xl-2">
                <a href="{{ route('admin.sub-categories.index') }}"
                    class="card bg-white border-0 rounded-4 p-3 h-100 shadow-sm text-decoration-none transition-all hover-translate-y border-top border-4 border-warning">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <div class="rounded-circle bg-warning bg-opacity-10 text-warning d-flex align-items-center justify-content-center"
                            style="width: 38px; height: 38px;">
                            <i class="bi bi-grid fs-5"></i>
                        </div>
                    </div>
                    <div class="text-secondary xx-small fw-bold text-uppercase tracking-widest mb-1 text-truncate">Sub Categories</div>
                    <h4 class="fw-black mb-0 text-dark">{{ number_format($totalSubcategories) }}</h4>
                </a>
            </div>
        @endif

        <!-- Products -->
        <!-- @if($isAdmin || ($subAdmin && $subAdmin->hasPermission('products_view')))
            <div class="col-6 col-sm-4 col-md-3 col-xl-2">
                <a href="{{ route('admin.products.index') }}"
                    class="card bg-white border-0 rounded-4 p-3 h-100 shadow-sm text-decoration-none transition-all hover-translate-y border-top border-4 border-success">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <div class="rounded-circle bg-success bg-opacity-10 text-success d-flex align-items-center justify-content-center"
                            style="width: 38px; height: 38px;">
                            <i class="bi bi-box-seam fs-5"></i>
                        </div>
                    </div>
                    <div class="text-secondary xx-small fw-bold text-uppercase tracking-widest mb-1 text-truncate">Products</div>
                    <h4 class="fw-black mb-0 text-dark">{{ number_format($products) }}</h4>
                </a>
            </div>
        @endif -->

        <!-- Offers & Coupons -->
        @if($isAdmin || ($subAdmin && $subAdmin->hasPermission('coupons_view')))
            <div class="col-6 col-sm-4 col-md-3 col-xl-2">
                <a href="{{ route('admin.coupons.index') }}"
                    class="card bg-white border-0 rounded-4 p-3 h-100 shadow-sm text-decoration-none transition-all hover-translate-y border-top border-4 border-info">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <div class="rounded-circle bg-info bg-opacity-10 text-info d-flex align-items-center justify-content-center"
                            style="width: 38px; height: 38px;">
                            <i class="bi bi-ticket-perforated fs-5"></i>
                        </div>
                    </div>
                    <div class="text-secondary xx-small fw-bold text-uppercase tracking-widest mb-1 text-truncate">Offers & Coupons</div>
                    <h4 class="fw-black mb-0 text-dark">{{ number_format($totalOffersAndCoupons) }}</h4>
                </a>
            </div>
        @endif

        <!-- Orders -->
        <!-- @if($isAdmin || ($subAdmin && $subAdmin->hasPermission('orders_view')))
            <div class="col-6 col-sm-4 col-md-3 col-xl-2">
                <a href="{{ route('admin.orders.index') }}"
                    class="card bg-white border-0 rounded-4 p-3 h-100 shadow-sm text-decoration-none transition-all hover-translate-y border-top border-4 border-primary">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <div class="rounded-circle text-primary d-flex align-items-center justify-content-center"
                            style="width: 38px; height: 38px; background-color: rgba(255, 184, 0, 0.1) !important;">
                            <i class="bi bi-cart-check fs-5"></i>
                        </div>
                        @if($pending > 0)
                            <span class="badge bg-warning text-white xx-small px-2 py-1 rounded-pill">Pending</span>
                        @endif
                    </div>
                    <div class="text-secondary xx-small fw-bold text-uppercase tracking-widest mb-1 text-truncate">Orders</div>
                    <h4 class="fw-black mb-0 text-dark">{{ number_format($orders) }}</h4>
                </a>
            </div>
        @endif -->

        <!-- Payments & Transactions -->
        @if($isAdmin || ($subAdmin && $subAdmin->hasPermission('transactions_view')))
            <div class="col-6 col-sm-4 col-md-3 col-xl-2">
                <a href="{{ route('admin.transactions.index') }}"
                    class="card bg-white border-0 rounded-4 p-3 h-100 shadow-sm text-decoration-none transition-all hover-translate-y border-top border-4 border-success">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <div class="rounded-circle bg-success bg-opacity-10 text-success d-flex align-items-center justify-content-center"
                            style="width: 38px; height: 38px;">
                            <i class="bi bi-journal-text fs-5"></i>
                        </div>
                    </div>
                    <div class="text-secondary xx-small fw-bold text-uppercase tracking-widest mb-1 text-truncate">Transactions</div>
                    <h4 class="fw-black mb-0 text-dark">{{ number_format($totalTransactions) }}</h4>
                </a>
            </div>
        @endif

        <!-- Wallet Bonus Deals -->
        @if($isAdmin || ($subAdmin && $subAdmin->hasPermission('wallet_deals_view')))
            <div class="col-6 col-sm-4 col-md-3 col-xl-2">
                <a href="{{ route('admin.wallet-offers.index') }}"
                    class="card bg-white border-0 rounded-4 p-3 h-100 shadow-sm text-decoration-none transition-all hover-translate-y border-top border-4 border-warning">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <div class="rounded-circle bg-warning bg-opacity-10 text-warning d-flex align-items-center justify-content-center"
                            style="width: 38px; height: 38px;">
                            <i class="bi bi-gift fs-5"></i>
                        </div>
                    </div>
                    <div class="text-secondary xx-small fw-bold text-uppercase tracking-widest mb-1 text-truncate">Wallet Deals</div>
                    <h4 class="fw-black mb-0 text-dark">{{ number_format($totalWalletOffers) }}</h4>
                </a>
            </div>
        @endif

        <!-- Users/Customers -->
        @if($isAdmin || ($subAdmin && $subAdmin->hasPermission('users_view')))
            <div class="col-6 col-sm-4 col-md-3 col-xl-2">
                <a href="{{ route('admin.users.index') }}"
                    class="card bg-white border-0 rounded-4 p-3 h-100 shadow-sm text-decoration-none transition-all hover-translate-y border-top border-4 border-danger">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <div class="rounded-circle bg-danger bg-opacity-10 text-danger d-flex align-items-center justify-content-center"
                            style="width: 38px; height: 38px;">
                            <i class="bi bi-people fs-5"></i>
                        </div>
                    </div>
                    <div class="text-secondary xx-small fw-bold text-uppercase tracking-widest mb-1 text-truncate">Customers</div>
                    <h4 class="fw-black mb-0 text-dark">{{ number_format($users) }}</h4>
                </a>
            </div>
        @endif

        <!-- Seller Inquiries -->
        @if($isAdmin || ($subAdmin && $subAdmin->hasPermission('seller_inquiries_view')))
            <div class="col-6 col-sm-4 col-md-3 col-xl-2">
                <a href="{{ route('admin.seller-inquiries.index') }}"
                    class="card bg-white border-0 rounded-4 p-3 h-100 shadow-sm text-decoration-none transition-all hover-translate-y border-top border-4 border-info">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <div class="rounded-circle bg-info bg-opacity-10 text-info d-flex align-items-center justify-content-center"
                            style="width: 38px; height: 38px;">
                            <i class="bi bi-shop fs-5"></i>
                        </div>
                    </div>
                    <div class="text-secondary xx-small fw-bold text-uppercase tracking-widest mb-1 text-truncate">Seller Inquiries</div>
                    <h4 class="fw-black mb-0 text-dark">{{ number_format($totalSellerInquiries) }}</h4>
                </a>
            </div>
        @endif

        <!-- Complaints -->
        @if($isAdmin || ($subAdmin && $subAdmin->hasPermission('complaints_view')))
            <div class="col-6 col-sm-4 col-md-3 col-xl-2">
                <a href="{{ route('admin.complaints.index') }}"
                    class="card bg-white border-0 rounded-4 p-3 h-100 shadow-sm text-decoration-none transition-all hover-translate-y border-top border-4 border-danger">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <div class="rounded-circle bg-danger bg-opacity-10 text-danger d-flex align-items-center justify-content-center"
                            style="width: 38px; height: 38px;">
                            <i class="bi bi-chat-left-text fs-5"></i>
                        </div>
                    </div>
                    <div class="text-secondary xx-small fw-bold text-uppercase tracking-widest mb-1 text-truncate">Complaints</div>
                    <h4 class="fw-black mb-0 text-dark">{{ number_format($totalComplaints) }}</h4>
                </a>
            </div>
        @endif

        <!-- Contact Inquiries -->
        @if($isAdmin || ($subAdmin && $subAdmin->hasPermission('contacts_view')))
            <div class="col-6 col-sm-4 col-md-3 col-xl-2">
                <a href="{{ route('admin.contacts.index') }}"
                    class="card bg-white border-0 rounded-4 p-3 h-100 shadow-sm text-decoration-none transition-all hover-translate-y border-top border-4 border-primary">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <div class="rounded-circle text-primary d-flex align-items-center justify-content-center"
                            style="width: 38px; height: 38px; background-color: rgba(255, 184, 0, 0.1) !important;">
                            <i class="bi bi-envelope fs-5"></i>
                        </div>
                    </div>
                    <div class="text-secondary xx-small fw-bold text-uppercase tracking-widest mb-1 text-truncate">Contacts</div>
                    <h4 class="fw-black mb-0 text-dark">{{ number_format($totalContacts) }}</h4>
                </a>
            </div>
        @endif

        <!-- Support Tickets -->
        @if($isAdmin || ($subAdmin && $subAdmin->hasPermission('support_view')))
            <div class="col-6 col-sm-4 col-md-3 col-xl-2">
                <a href="{{ route('admin.support-tickets.index') }}"
                    class="card bg-white border-0 rounded-4 p-3 h-100 shadow-sm text-decoration-none transition-all hover-translate-y border-top border-4 border-success">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <div class="rounded-circle bg-success bg-opacity-10 text-success d-flex align-items-center justify-content-center"
                            style="width: 38px; height: 38px;">
                            <i class="bi bi-headset fs-5"></i>
                        </div>
                    </div>
                    <div class="text-secondary xx-small fw-bold text-uppercase tracking-widest mb-1 text-truncate">Support Tickets</div>
                    <h4 class="fw-black mb-0 text-dark">{{ number_format($totalSupportTickets) }}</h4>
                </a>
            </div>
        @endif

        <!-- Product Reviews -->
        @if($isAdmin || ($subAdmin && $subAdmin->hasPermission('reviews_view')))
            <div class="col-6 col-sm-4 col-md-3 col-xl-2">
                <a href="{{ route('admin.reviews.index') }}"
                    class="card bg-white border-0 rounded-4 p-3 h-100 shadow-sm text-decoration-none transition-all hover-translate-y border-top border-4 border-warning">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <div class="rounded-circle bg-warning bg-opacity-10 text-warning d-flex align-items-center justify-content-center"
                            style="width: 38px; height: 38px;">
                            <i class="bi bi-star-half fs-5"></i>
                        </div>
                    </div>
                    <div class="text-secondary xx-small fw-bold text-uppercase tracking-widest mb-1 text-truncate">Product Reviews</div>
                    <h4 class="fw-black mb-0 text-dark">{{ number_format($totalReviews) }}</h4>
                </a>
            </div>
        @endif

        <!-- Refund & Cancellations -->
        @if($isAdmin || ($subAdmin && $subAdmin->hasPermission('refunds_view')))
            <div class="col-6 col-sm-4 col-md-3 col-xl-2">
                <a href="{{ route('admin.refunds.index') }}"
                    class="card bg-white border-0 rounded-4 p-3 h-100 shadow-sm text-decoration-none transition-all hover-translate-y border-top border-4 border-danger">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <div class="rounded-circle bg-danger bg-opacity-10 text-danger d-flex align-items-center justify-content-center"
                            style="width: 38px; height: 38px;">
                            <i class="bi bi-arrow-counterclockwise fs-5"></i>
                        </div>
                    </div>
                    <div class="text-secondary xx-small fw-bold text-uppercase tracking-widest mb-1 text-truncate">Refunds / Cancels</div>
                    <h4 class="fw-black mb-0 text-dark">{{ number_format($totalRefunds) }}</h4>
                </a>
            </div>
        @endif

        <!-- Manage FAQs -->
        @if($isAdmin || ($subAdmin && $subAdmin->hasPermission('faqs_view')))
            <div class="col-6 col-sm-4 col-md-3 col-xl-2">
                <a href="{{ route('admin.faqs.index') }}"
                    class="card bg-white border-0 rounded-4 p-3 h-100 shadow-sm text-decoration-none transition-all hover-translate-y border-top border-4 border-info">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <div class="rounded-circle bg-info bg-opacity-10 text-info d-flex align-items-center justify-content-center"
                            style="width: 38px; height: 38px;">
                            <i class="bi bi-question-circle fs-5"></i>
                        </div>
                    </div>
                    <div class="text-secondary xx-small fw-bold text-uppercase tracking-widest mb-1 text-truncate">FAQs Base</div>
                    <h4 class="fw-black mb-0 text-dark">{{ number_format($totalFaqs) }}</h4>
                </a>
            </div>
        @endif

        <!-- Manage Hero Sliders -->
        @if($isAdmin || ($subAdmin && $subAdmin->hasPermission('home_sliders_view')))
            <div class="col-6 col-sm-4 col-md-3 col-xl-2">
                <a href="{{ route('admin.home-sliders.index') }}"
                    class="card bg-white border-0 rounded-4 p-3 h-100 shadow-sm text-decoration-none transition-all hover-translate-y border-top border-4 border-primary">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <div class="rounded-circle text-primary d-flex align-items-center justify-content-center"
                            style="width: 38px; height: 38px; background-color: rgba(255, 184, 0, 0.1) !important;">
                            <i class="bi bi-images fs-5"></i>
                        </div>
                    </div>
                    <div class="text-secondary xx-small fw-bold text-uppercase tracking-widest mb-1 text-truncate">Hero Sliders</div>
                    <h4 class="fw-black mb-0 text-dark">{{ number_format($totalSliders) }}</h4>
                </a>
            </div>
        @endif

        <!-- Sub Admin System -->
        @if($isAdmin)
            <div class="col-6 col-sm-4 col-md-3 col-xl-2">
                <a href="{{ route('admin.subadmins.index') }}"
                    class="card bg-white border-0 rounded-4 p-3 h-100 shadow-sm text-decoration-none transition-all hover-translate-y border-top border-4 border-dark">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <div class="rounded-circle text-dark d-flex align-items-center justify-content-center"
                            style="width: 38px; height: 38px; background-color: rgba(0, 0, 0, 0.08) !important;">
                            <i class="bi bi-shield-lock fs-5"></i>
                        </div>
                    </div>
                    <div class="text-secondary xx-small fw-bold text-uppercase tracking-widest mb-1 text-truncate">Sub Admins</div>
                    <h4 class="fw-black mb-0 text-dark">{{ number_format($totalSubAdmins) }}</h4>
                </a>
            </div>
        @endif
    </div>
    @endif

    @php
        $showRevenueChart = $isAdmin || ($subAdmin && ($subAdmin->hasPermission('transactions_view') || $subAdmin->hasPermission('orders_view')));
        $showOrderStatusChart = $isAdmin || ($subAdmin && $subAdmin->hasPermission('orders_view'));
    @endphp

    @if($showRevenueChart || $showOrderStatusChart)
    <!-- Analytics Chart & Modules -->
    <div class="row g-4 mb-5">
        @if($showRevenueChart)
        <!-- Chart Area -->
        <div class="{{ $showOrderStatusChart ? 'col-xl-8' : 'col-xl-12' }}">
            <div class="card bg-white border-0 rounded-4 p-4 h-100 shadow-sm">
                <div class="d-flex justify-content-between align-items-end mb-4 flex-wrap gap-3">
                    <div>
                        <h5 class="fw-bold mb-1 text-dark d-flex align-items-center gap-2">
                            Revenue Growth Graph
                        </h5>
                        <p class="text-secondary x-small mb-0 fw-medium">Sales trajectory over the last 6 months</p>
                    </div>
                    <select id="chartFilter"
                        class="form-select bg-light border-0 text-dark small w-auto shadow-none rounded-pill px-4 py-2 fw-bold">
                        <option value="6months">Last 6 Months</option>
                        <option value="thisyear">This Year</option>
                        <option value="alltime">All Time</option>
                    </select>
                </div>
                <div class="flex-grow-1 position-relative" style="min-height: 340px;">
                    <canvas id="revenueChart"></canvas>
                </div>
            </div>
        </div>
        @endif

        @if($showOrderStatusChart)
        <!-- Order Fulfillment Status Chart -->
        <div class="{{ $showRevenueChart ? 'col-xl-4' : 'col-xl-12' }}">
            <div class="card bg-white border-0 rounded-4 p-4 h-100 shadow-sm d-flex flex-column">
                <h5 class="fw-bold mb-1 text-dark">Order Status Breakdown</h5>
                <p class="text-secondary x-small mb-4 fw-medium">Distribution of all active orders</p>

                <div class="flex-grow-1 d-flex align-items-center justify-content-center" style="min-height: 250px; position: relative;">
                    <canvas id="orderStatusChart"></canvas>
                </div>
            </div>
        </div>
        @endif
    </div>
    @endif

    @if($isAdmin || ($subAdmin && ($subAdmin->hasPermission('orders_view') || $subAdmin->hasPermission('transactions_view'))))
    <!-- Recent Transactions Table -->
    <div class="card bg-white border-0 rounded-4 shadow-sm overflow-hidden mb-4 p-0">
        <div
            class="p-4 border-bottom d-flex justify-content-between align-items-center flex-wrap gap-3 bg-light bg-opacity-50">
            <div>
                <h5 class="fw-bold mb-1 text-dark">Latest Real-time Transactions</h5>
                <p class="text-secondary xx-small fw-bold text-uppercase tracking-widest mb-0">Recent
                    {{ count($stats['recent_orders']) }} incoming orders across all hubs
                </p>
            </div>
            <a href="{{ route('admin.orders.index') }}"
                class="btn btn-dark btn-sm rounded-pill px-4 py-2 x-small fw-bold shadow-sm d-flex align-items-center gap-2">View
                Entire Ledger <i class="bi bi-arrow-right"></i></a>
        </div>
        <div class="table-responsive">
            <table class="table table-hover table-borderless align-middle mb-0 w-100">
                <thead class="bg-light text-secondary border-bottom">
                    <tr>
                        <th class="x-small fw-bold py-3 px-4 tracking-widest text-uppercase">Trx ID</th>
                        <th class="x-small fw-bold py-3 px-3 tracking-widest text-uppercase">Customer Profile</th>
                        <th class="x-small fw-bold py-3 px-3 tracking-widest text-uppercase">Fulfillment Status</th>
                        <th class="x-small fw-bold py-3 px-4 text-end tracking-widest text-uppercase">Invoice Value</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($stats['recent_orders'] as $order)
                        <tr class="border-bottom transition-all">
                            <td class="small fw-black py-4 px-4 text-dark">
                                <span
                                    class="bg-light text-dark px-3 py-2 rounded-3 shadow-sm border border-black border-opacity-10">
                                    <i class="bi bi-hash text-primary opacity-50"></i>{{ $order->order_number }}
                                </span>
                            </td>
                            <td class="px-3">
                                <div class="d-flex align-items-center gap-3">
                                    @php
                                        $colors = ['primary', 'success', 'warning', 'danger', 'info'];
                                        $scolor = $colors[abs(crc32($order->user->id)) % count($colors)];
                                        $bgStyle = $scolor === 'primary' ? 'background-color: rgba(255, 122, 24, 0.1) !important;' : '';
                                    @endphp
                                    <div class="rounded-circle bg-{{ $scolor }} bg-opacity-10 text-{{ $scolor }} d-flex align-items-center justify-content-center fw-black shadow-sm"
                                        style="width: 40px; height: 40px; font-size: 1.1rem; {{ $bgStyle }}">
                                        {{ strtoupper(substr($order->user->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="text-dark small fw-bold">{{ $order->user->name }}</div>
                                        <div class="xx-small text-secondary fw-bold mt-1">{{ $order->user->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-3">
                                @php
                                    $badgeColor = 'primary';
                                    $ordStatus = strtolower($order->order_status ?? '');
                                    if ($ordStatus == 'completed' || $ordStatus == 'delivered')
                                        $badgeColor = 'success';
                                    if ($ordStatus == 'pending')
                                        $badgeColor = 'white';
                                    if ($ordStatus == 'cancelled')
                                        $badgeColor = 'danger';
                                @endphp
                                <span
                                    class="badge bg-{{ $badgeColor }} px-3 py-2 rounded-pill x-small fw-bold d-inline-flex align-items-center shadow-sm text-white">
                                    <span style="letter-spacing: 0.5px;">{{ strtoupper($ordStatus ?: 'UNKNOWN') }}</span>
                                </span>
                            </td>
                            <td class="text-end fw-black fs-6 text-dark px-4">
                                ₹{{ number_format($order->total_amount, 2) }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-5">
                                <div class="py-4">
                                    <i class="bi bi-inbox fs-1 text-secondary opacity-25 mb-3 d-block"></i>
                                    <h6 class="text-dark fw-bold">No active transactions.</h6>
                                    <p class="text-secondary small mb-0">It looks like there are no recent orders to show here.
                                    </p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @endif
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const ctx = document.getElementById('revenueChart');
            if (!ctx) return;

            const ctx2d = ctx.getContext('2d');

            // Premium Light Theme Gradient Fill
            let gradientFill = ctx2d.createLinearGradient(0, 0, 0, 400);
            gradientFill.addColorStop(0, 'rgba(16, 185, 129, 0.25)'); // Success green at top
            gradientFill.addColorStop(1, 'rgba(255, 255, 255, 0)');     // Fade to white

            // Pre-loaded datasets for filter switching
            const chartDataSets = {
                '6months': {
                    labels: {!! json_encode($months) !!},
                    data: {!! json_encode($chartData) !!}
                },
                'thisyear': {
                    labels: {!! json_encode($thisYearMonths) !!},
                    data: {!! json_encode($thisYearData) !!}
                },
                'alltime': {
                    labels: {!! json_encode($allTimeLabels) !!},
                    data: {!! json_encode($allTimeData) !!}
                }
            };

            const revenueChart = new Chart(ctx2d, {
                type: 'line',
                data: {
                    labels: chartDataSets['6months'].labels,
                    datasets: [{
                        label: 'Revenue Tracker',
                        data: chartDataSets['6months'].data,
                        borderColor: '#10b981', // Solid premium green
                        backgroundColor: gradientFill,
                        borderWidth: 4,
                        pointBackgroundColor: '#fff',
                        pointBorderColor: '#10b981',
                        pointBorderWidth: 3,
                        pointRadius: 6,
                        pointHoverRadius: 8,
                        pointHoverBackgroundColor: '#10b981',
                        pointHoverBorderColor: '#fff',
                        fill: true,
                        tension: 0.4 // Smooth Bezier
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    interaction: {
                        mode: 'index',
                        intersect: false,
                    },
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: '#111827',
                            titleColor: '#9ca3af',
                            bodyColor: '#fff',
                            titleFont: { size: 13, weight: 'bold' },
                            bodyFont: { size: 16, weight: 'bold' },
                            padding: 16,
                            cornerRadius: 12,
                            displayColors: false,
                            callbacks: {
                                label: function (context) {
                                    return '₹ ' + context.parsed.y.toLocaleString();
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: 'rgba(0, 0, 0, 0.04)',
                                drawBorder: false,
                                borderDash: [5, 5]
                            },
                            ticks: {
                                color: '#6b7280',
                                font: { size: 12, weight: '600' },
                                callback: function (value) { 
                                    if (value >= 1000) {
                                        return '₹' + (value / 1000) + 'k'; 
                                    }
                                    return '₹' + value;
                                },
                                padding: 15
                            }
                        },
                        x: {
                            grid: { display: false, drawBorder: false },
                            ticks: {
                                color: '#6b7280',
                                font: { size: 13, weight: 'bold' },
                                padding: 10
                            }
                        }
                    }
                }
            });

            // Listen to dropdown changes
            const filterSelect = document.getElementById('chartFilter');
            if (filterSelect) {
                filterSelect.addEventListener('change', function () {
                    const selectedVal = this.value;
                    const selectedDataSet = chartDataSets[selectedVal];
                    
                    revenueChart.data.labels = selectedDataSet.labels;
                    revenueChart.data.datasets[0].data = selectedDataSet.data;
                    revenueChart.update();
                });
            }

            // Order Fulfillment Status Doughnut Chart
            const statusCtx = document.getElementById('orderStatusChart');
            if (statusCtx) {
                const statusCtx2d = statusCtx.getContext('2d');
                new Chart(statusCtx2d, {
                    type: 'doughnut',
                    data: {
                        labels: {!! json_encode($statusLabels) !!},
                        datasets: [{
                            data: {!! json_encode($statusCounts) !!},
                            backgroundColor: [
                                '#FFB800', // Saffron / Orange-Yellow
                                '#0d6efd', // Blue
                                '#198754', // Green
                                '#0dcaf0', // Cyan
                                '#6610f2', // Purple
                                '#20c997', // Teal
                                '#fd7e14', // Orange
                                '#dc3545'  // Red
                            ],
                            borderWidth: 2,
                            borderColor: '#ffffff',
                            hoverOffset: 4
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: {
                                    boxWidth: 10,
                                    padding: 10,
                                    font: {
                                        size: 10,
                                        weight: '600'
                                    },
                                    color: '#4b5563'
                                }
                            },
                            tooltip: {
                                backgroundColor: '#111827',
                                bodyColor: '#fff',
                                padding: 12,
                                cornerRadius: 8,
                                displayColors: false
                            }
                        },
                        cutout: '70%' // Sleek doughnut ring
                    }
                });
            }
        });
    </script>

    <style>
        .xx-small {
            font-size: 0.68rem !important;
            letter-spacing: 0.05em !important;
        }

        /* Premium Utilities Extracted for Dashboard */
        .pulse-dot-container {
            display: inline-flex;
            align-items: center;
        }

        .pulse-dot {
            box-shadow: 0 0 0 0 rgba(255, 184, 0, 0.7);
            animation: pulseDot 2s infinite;
        }

        @keyframes pulseDot {
            0% {
                transform: scale(0.95);
                box-shadow: 0 0 0 0 rgba(255, 184, 0, 0.7);
            }

            70% {
                transform: scale(1);
                box-shadow: 0 0 0 6px rgba(255, 184, 0, 0);
            }

            100% {
                transform: scale(0.95);
                box-shadow: 0 0 0 0 rgba(255, 184, 0, 0);
            }
        }

        .tracking-widest {
            letter-spacing: 0.1em;
        }

        .hover-shadow-lg:hover {
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.06) !important;
            transform: translateY(-3px);
        }

        .hover-translate-y:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1) !important;
        }

        .hover-shadow-sm:hover {
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.04) !important;
            transform: translateX(3px);
        }

        /* Elegant Hover State mapping for modules */
        .group:hover .group-hover-bg-primary {
            background: #0d6efd !important;
            color: white !important;
        }

        .group:hover .group-hover-bg-warning {
            background: #ffc107 !important;
            color: white !important;
            text-shadow: none;
        }

        .group:hover .group-hover-bg-success {
            background: #198754 !important;
            color: white !important;
        }
    </style>
@endpush