<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Product;
use App\Models\Order;
use App\Models\User;
use App\Models\Coupon;
use App\Models\Offer;
use App\Models\WalletTransaction;
use App\Models\WalletOffer;
use App\Models\SellerInquiry;
use App\Models\Complaint;
use App\Models\Contact;
use App\Models\SupportTicket;
use App\Models\ProductReview;
use App\Models\Refund;
use App\Models\Faq;
use App\Models\HomeSlider;
use App\Models\SubAdmin;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_users' => User::count(),
            'total_products' => Product::count(),
            'total_orders' => Order::whereNotIn('order_status', ['payment_pending', 'payment_failed', 'cancelled'])->count(),
            'total_categories' => Category::count(),
            'recent_orders' => Order::with('user')->whereNotIn('order_status', ['payment_pending', 'payment_failed', 'cancelled'])->orderBy('created_at', 'desc')->limit(5)->get(),
        ];

        $rev = Order::where('payment_status', 'paid')->sum('total_amount') ?? 0;
        $pending = Order::whereIn('order_status', ['placed', 'confirmed'])->count() ?? 0;
        $totalSubcategories = SubCategory::count() ?? 0;
        $totalCoupons = Coupon::count() ?? 0;
        $totalOffers = Offer::count() ?? 0;
        $totalWalletTransactions = WalletTransaction::count() ?? 0;
        $totalOrderPayments = Order::where('payment_status', 'paid')->count() ?? 0;
        $totalWalletOffers = WalletOffer::count() ?? 0;
        $totalSellerInquiries = SellerInquiry::count() ?? 0;
        $totalComplaints = Complaint::count() ?? 0;
        $totalContacts = Contact::count() ?? 0;
        $totalSupportTickets = SupportTicket::count() ?? 0;
        $totalReviews = ProductReview::count() ?? 0;
        $totalRefunds = Refund::count() ?? 0;
        $totalFaqs = Faq::count() ?? 0;
        $totalSliders = HomeSlider::count() ?? 0;
        $totalSubAdmins = SubAdmin::count() ?? 0;

        // Fetch revenue for last 6 months dynamically
        $months = [];
        $chartData = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $months[] = $date->format('M');
            $chartData[] = Order::where('payment_status', 'paid')
                ->whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->sum('total_amount') ?? 0;
        }

        // Fetch revenue for this year dynamically
        $thisYearMonths = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        $thisYearData = [];
        $currentYear = now()->year;
        for ($m = 1; $m <= 12; $m++) {
            $thisYearData[] = Order::where('payment_status', 'paid')
                ->whereYear('created_at', $currentYear)
                ->whereMonth('created_at', $m)
                ->sum('total_amount') ?? 0;
        }

        // Fetch revenue for all time dynamically (grouped by year)
        $yearsData = Order::where('payment_status', 'paid')
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
                $allTimeLabels[] = (string) $yData->year;
                $allTimeData[] = (float) $yData->total;
            }
        }

        // Fetch order status breakdown dynamically
        $orderStatuses = Order::selectRaw('order_status, count(*) as count')
            ->groupBy('order_status')
            ->get();

        $statusLabels = [];
        $statusCounts = [];
        foreach ($orderStatuses as $os) {
            $statusLabels[] = ucfirst(str_replace('_', ' ', $os->order_status));
            $statusCounts[] = $os->count;
        }

        return view('admin.dashboard', compact(
            'stats', 'rev', 'pending', 'totalSubcategories', 'totalCoupons', 'totalOffers',
            'totalWalletTransactions', 'totalOrderPayments', 'totalWalletOffers', 'totalSellerInquiries',
            'totalComplaints', 'totalContacts', 'totalSupportTickets', 'totalReviews', 'totalRefunds',
            'totalFaqs', 'totalSliders', 'totalSubAdmins', 'months', 'chartData', 'thisYearMonths',
            'thisYearData', 'allTimeLabels', 'allTimeData', 'statusLabels', 'statusCounts'
        ));
    }

    public function profile()
    {
        return view('admin.profile');
    }
}
