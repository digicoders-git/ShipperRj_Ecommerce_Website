<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SellerInquiry;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class SellerInquiryController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('check.subadmin:seller_inquiries_view', only: ['index', 'show']),
            new Middleware('check.subadmin:seller_inquiries_delete', only: ['destroy']),
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $inquiries = SellerInquiry::latest()->get();
        return view('admin.seller_inquiries.index', compact('inquiries'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $inquiry = SellerInquiry::findOrFail($id);
        return view('admin.seller_inquiries.show', compact('inquiry'));
    }

    /**
     * Update the status of the inquiry.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,rejected',
        ]);

        $inquiry = SellerInquiry::findOrFail($id);
        $inquiry->status = $request->status;
        $inquiry->save();

        return redirect()->back()->with('success', 'Inquiry status updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $inquiry = SellerInquiry::findOrFail($id);
        $inquiry->delete();

        return redirect()->route('admin.seller-inquiries.index')->with('success', 'Inquiry deleted successfully.');
    }
}
