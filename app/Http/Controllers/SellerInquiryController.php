<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SellerInquiry;

class SellerInquiryController extends Controller
{
    public function index()
    {
        return view('seller_inquiry');
    }

    public function submit(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'business_name' => 'nullable|string|max:255',
            'business_type' => 'nullable|string|max:255',
            'message' => 'nullable|string',
        ]);

        SellerInquiry::create($request->all());

        return redirect()->back()->with('success', 'Your inquiry has been submitted successfully. We will get back to you soon.');
    }
}
