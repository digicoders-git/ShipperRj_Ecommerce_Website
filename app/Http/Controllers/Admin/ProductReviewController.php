<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductReview;
use Illuminate\Http\Request;

use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class ProductReviewController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('check.subadmin:reviews_view', only: ['index']),
            new Middleware('check.subadmin:reviews_update', only: ['update']),
            new Middleware('check.subadmin:reviews_delete', only: ['destroy']),
        ];
    }
    public function index()
    {
        $reviews = ProductReview::with(['user', 'product'])->latest()->get();
        return view('admin.reviews', compact('reviews'));
    }

    public function update(Request $request, $id)
    {
        $review = ProductReview::findOrFail($id);
        
        $request->validate([
            'status' => 'required|integer|in:0,1,2',
            'admin_reply' => 'nullable|string|max:1000',
        ]);

        $review->update([
            'status' => $request->status,
            'admin_reply' => $request->admin_reply,
        ]);

        return back()->with('success', 'Review status updated successfully.');
    }

    public function destroy($id)
    {
        $review = ProductReview::findOrFail($id);
        $review->delete();

        return back()->with('success', 'Review deleted successfully.');
    }
}
