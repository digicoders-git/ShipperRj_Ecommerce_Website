<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Faq;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class FaqController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('check.subadmin:faqs_view', only: ['index']),
            new Middleware('check.subadmin:faqs_add', only: ['store']),
            new Middleware('check.subadmin:faqs_edit', only: ['update']),
            new Middleware('check.subadmin:faqs_delete', only: ['destroy']),
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $faqs = Faq::orderBy('sort_order', 'asc')->latest()->get();
        return view('admin.faqs', compact('faqs'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'question' => 'required|string',
            'answer' => 'required|string',
            'status' => 'required|in:0,1',
            'sort_order' => 'nullable|integer',
        ]);

        Faq::create([
            'question' => $request->question,
            'answer' => $request->answer,
            'status' => $request->status,
            'sort_order' => $request->sort_order ?? 0,
        ]);

        return redirect()->back()->with('success', 'FAQ added successfully.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'question' => 'required|string',
            'answer' => 'required|string',
            'status' => 'required|in:0,1',
            'sort_order' => 'nullable|integer',
        ]);

        $faq = Faq::findOrFail($id);
        $faq->update([
            'question' => $request->question,
            'answer' => $request->answer,
            'status' => $request->status,
            'sort_order' => $request->sort_order ?? 0,
        ]);

        return redirect()->back()->with('success', 'FAQ updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $faq = Faq::findOrFail($id);
        $faq->delete();

        return redirect()->back()->with('success', 'FAQ deleted successfully.');
    }
}
