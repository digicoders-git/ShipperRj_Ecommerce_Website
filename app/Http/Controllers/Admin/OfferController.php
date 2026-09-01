<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Offer;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\File;

class OfferController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $offers = Offer::with(['category', 'product'])->latest()->get();
        $categories = Category::all();
        $products = Product::where('status', 1)->get();
        return view('admin.offers', compact('offers', 'categories', 'products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'offer_name' => 'required|string|max:255',
            'offer_type' => 'required|string|max:100',
            'category_id' => 'required|exists:categories,id',
            'discount_type' => 'required|in:percentage,fixed',
            'discount_value' => 'required|numeric|min:0.01',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp,gif|max:4096',
        ]);

        $offer = new Offer();
        $offer->offer_name = $request->offer_name;
        $offer->offer_type = $request->offer_type;
        $offer->category_id = $request->category_id;
        $offer->product_id = $request->product_id ?? null;
        $offer->discount_type = $request->discount_type;
        $offer->discount_value = $request->discount_value;
        $offer->discount_percentage = ($request->discount_type === 'percentage') ? $request->discount_value : null;
        $offer->start_date = $request->start_date;
        $offer->end_date = $request->end_date;
        $offer->status = $request->has('status') ? (int) $request->status : 1;

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $path = 'uploads/offers/';
            $file->move(public_path($path), $filename);
            $offer->image = $path . $filename;
        }

        $offer->save();

        return redirect()->back()->with('success', 'Category Live Offer added successfully.');
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'offer_name' => 'required|string|max:255',
            'offer_type' => 'required|string|max:100',
            'category_id' => 'required|exists:categories,id',
            'discount_type' => 'required|in:percentage,fixed',
            'discount_value' => 'required|numeric|min:0.01',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp,gif|max:4096',
        ]);

        $offer = Offer::findOrFail($id);
        $offer->offer_name = $request->offer_name;
        $offer->offer_type = $request->offer_type;
        $offer->category_id = $request->category_id;
        $offer->product_id = $request->product_id ?? null;
        $offer->discount_type = $request->discount_type;
        $offer->discount_value = $request->discount_value;
        $offer->discount_percentage = ($request->discount_type === 'percentage') ? $request->discount_value : null;
        $offer->start_date = $request->start_date;
        $offer->end_date = $request->end_date;
        $offer->status = $request->has('status') ? (int) $request->status : 1;

        if ($request->hasFile('image')) {
            // Remove old image if exists
            if ($offer->image && File::exists(public_path($offer->image))) {
                File::delete(public_path($offer->image));
            }

            $file = $request->file('image');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $path = 'uploads/offers/';
            $file->move(public_path($path), $filename);
            $offer->image = $path . $filename;
        }

        $offer->save();

        return redirect()->back()->with('success', 'Category Live Offer updated successfully.');
    }

    public function destroy(string $id)
    {
        $offer = Offer::findOrFail($id);
        if ($offer->image && File::exists(public_path($offer->image))) {
            File::delete(public_path($offer->image));
        }
        $offer->delete();
        return redirect()->back()->with('success', 'Offer deleted successfully.');
    }
}
