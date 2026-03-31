<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Offer;
use App\Models\Product;

class OfferController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $offers = Offer::with('product')->latest()->get();
        $products = Product::where('status', 1)->get();
        return view('admin.offers', compact('offers', 'products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'discount_percentage' => 'required|numeric|min:1|max:100',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $offer = new Offer();
        $offer->product_id = $request->product_id;
        $offer->discount_percentage = $request->discount_percentage;
        $offer->start_date = $request->start_date;
        $offer->end_date = $request->end_date;
        $offer->status = $request->status ?? 1;
        $offer->save();

        return redirect()->back()->with('success', 'Offer added successfully.');
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'discount_percentage' => 'required|numeric|min:1|max:100',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $offer = Offer::findOrFail($id);
        $offer->product_id = $request->product_id;
        $offer->discount_percentage = $request->discount_percentage;
        $offer->start_date = $request->start_date;
        $offer->end_date = $request->end_date;
        $offer->status = $request->status ?? 1;
        $offer->save();

        return redirect()->back()->with('success', 'Offer updated successfully.');
    }

    public function destroy(string $id)
    {
        $offer = Offer::findOrFail($id);
        $offer->delete();
        return redirect()->back()->with('success', 'Offer deleted successfully.');
    }
}

