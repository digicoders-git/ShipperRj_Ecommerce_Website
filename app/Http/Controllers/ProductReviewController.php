<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\ProductReview;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductReviewController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        $user_id = Auth::id();
        $product_id = $request->product_id;

        // Check if the user has ordered this product and the order is delivered
        $hasOrdered = Order::where('user_id', $user_id)
            ->where('order_status', 'delivered')
            ->whereHas('orderItems', function ($query) use ($product_id) {
                $query->where('product_id', $product_id);
            })->exists();

        if (!$hasOrdered) {
            return back()->with('error', 'You can only review products you have purchased and that have been delivered.');
        }

        // Check if the user has already reviewed this product
        $existingReview = ProductReview::where('user_id', $user_id)
            ->where('product_id', $product_id)
            ->first();

        if ($existingReview) {
            return back()->with('error', 'You have already reviewed this product.');
        }

        ProductReview::create([
            'user_id' => $user_id,
            'product_id' => $product_id,
            'rating' => $request->rating,
            'comment' => $request->comment,
            'status' => 0, // 0: Pending, 1: Approved, 2: Rejected
        ]);

        return back()->with('success', 'Thank you for your review! It will be visible once approved by the admin.');
    }
}
