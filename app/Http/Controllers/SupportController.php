<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SupportTicket;

class SupportController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => ['required', 'regex:/^[6789]\d{9}$/'],
            'message' => 'required|string',
            'suggestion' => 'nullable|string',
        ], [
            'phone.regex' => 'Mobile number must start with 6, 7, 8, or 9 and must be exactly 10 digits.',
        ]);

        SupportTicket::create($request->all());

        return response()->json(['success' => 'Support & Feedback submitted successfully!']);
    }
}
