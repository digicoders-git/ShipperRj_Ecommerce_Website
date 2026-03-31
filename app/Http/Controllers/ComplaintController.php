<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ComplaintController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'product_id' => 'nullable|exists:products,id',
            'message' => 'required|string',
        ]);

        Complaint::create([
            'user_id' => Auth::id(),
            'product_id' => $request->product_id,
            'subject' => $request->subject,
            'message' => $request->message,
            'status' => 'pending' // Default status
        ]);

        return back()->with('success', 'Your support case has been successfully initialized. Our team will review it shortly.');
    }
}
