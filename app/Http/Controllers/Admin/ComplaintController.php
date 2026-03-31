<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Complaint;

class ComplaintController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $complaints = Complaint::with(['user', 'product'])->latest()->get();
        return view('admin.complaints', compact('complaints'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'status' => 'required|string',
            'admin_comment' => 'nullable|string|max:1000'
        ]);

        $complaint = Complaint::findOrFail($id);
        $complaint->status = $request->status;
        $complaint->admin_comment = $request->admin_comment;
        $complaint->save();

        return redirect()->back()->with('success', 'Complaint status and resolution updated.');
    }
}

