<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use App\Models\Order;
use App\Models\User;

class DashboardController extends Controller
{

    public function index()
    {
        $stats = [
            'total_users' => User::count(),
            'total_products' => Product::count(),
            'total_orders' => Order::count(),
            'total_categories' => Category::count(),
            'recent_orders' => Order::with('user')->latest()->limit(5)->get(),
        ];
        return view('admin.dashboard', compact('stats'));
    }

    public function profile()
    {
        return view('admin.profile');
    }
}

