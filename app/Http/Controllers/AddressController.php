<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserAddress;
use Illuminate\Support\Facades\Auth;

class AddressController extends Controller
{
    public function index()
    {
        $addresses = UserAddress::where('user_id', Auth::id())->latest()->get();
        return view('profile-addresses', compact('addresses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'mobile' => 'required|string|max:15',
            'alt_mobile' => 'nullable|string|max:15',
            'address_line' => 'required|string',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'pincode' => 'required|string|max:10',
            'landmark' => 'nullable|string|max:255',
            'type' => 'nullable|string'
        ]);

        $is_first = UserAddress::where('user_id', Auth::id())->count() === 0;

        UserAddress::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'mobile' => $request->mobile,
            'alt_mobile' => $request->alt_mobile,
            'address_line' => $request->address_line,
            'city' => $request->city,
            'state' => $request->state,
            'pincode' => $request->pincode,
            'landmark' => $request->landmark,
            'type' => $request->type ?? 'Home',
            'is_default' => $is_first ? true : false
        ]);

        return back()->with('success', 'Address added successfully!');
    }

    public function update(Request $request, $id)
    {
        $address = UserAddress::where('user_id', Auth::id())->findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'mobile' => 'required|string|max:15',
            'alt_mobile' => 'nullable|string|max:15',
            'address_line' => 'required|string',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'pincode' => 'required|string|max:10',
            'landmark' => 'nullable|string|max:255',
            'type' => 'nullable|string'
        ]);

        $address->update($request->all());

        return back()->with('success', 'Address updated successfully!');
    }

    public function destroy($id)
    {
        $address = UserAddress::where('user_id', Auth::id())->findOrFail($id);
        
        // If we are deleting a default address, pick another one as default if exists
        $wasDefault = $address->is_default;
        
        $address->delete();

        if ($wasDefault) {
            $next = UserAddress::where('user_id', Auth::id())->first();
            if ($next) {
                $next->update(['is_default' => true]);
            }
        }

        return back()->with('success', 'Address deleted successfully!');
    }

    public function setDefault($id)
    {
        $address = UserAddress::where('user_id', Auth::id())->findOrFail($id);

        // Reset all others
        UserAddress::where('user_id', Auth::id())->update(['is_default' => false]);

        // Set this one
        $address->update(['is_default' => true]);

        return back()->with('success', 'Default address updated!');
    }
}
