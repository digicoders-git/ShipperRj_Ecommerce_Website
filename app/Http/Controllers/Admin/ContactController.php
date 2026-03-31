<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $contacts = \App\Models\Contact::latest()->paginate(20);
        return view('admin.contacts', compact('contacts'));
    }

    public function destroy(string $id)
    {
        $contact = \App\Models\Contact::findOrFail($id);
        $contact->delete();
        return redirect()->back()->with('success', 'Message deleted successfully');
    }
}
