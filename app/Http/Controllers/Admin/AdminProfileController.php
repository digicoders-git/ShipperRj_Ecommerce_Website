<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\SubAdmin;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AdminProfileController extends Controller
{
    public function index()
    {
        $admin = Auth::guard('admin')->check() 
            ? Auth::guard('admin')->user() 
            : Auth::guard('subadmin')->user();
        return view('admin.profile', compact('admin'));
    }

    public function update(Request $request)
    {
        if (Auth::guard('admin')->check()) {
            $request->validate([
                'name' => 'required',
                'email' => 'required|email|unique:admins,email,' . Auth::guard('admin')->id(),
            ]);

            $user = Admin::findOrFail(Auth::guard('admin')->id());
            $user->name = $request->name;
            $user->email = $request->email;
            $user->save();
        } else {
            $request->validate([
                'name' => 'required',
                'email' => 'required|email|unique:sub_admins,email,' . Auth::guard('subadmin')->id(),
            ]);

            $user = SubAdmin::findOrFail(Auth::guard('subadmin')->id());
            $user->name = $request->name;
            $user->email = $request->email;
            $user->save();
        }

        return redirect()->back()->with('success', 'Profile updated successfully.');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:6|confirmed',
        ], [
            'password.confirmed' => 'New and confirm password not match',
        ]);

        if (Auth::guard('admin')->check()) {
            $user = Admin::findOrFail(Auth::guard('admin')->id());
        } else {
            $user = SubAdmin::findOrFail(Auth::guard('subadmin')->id());
        }

        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->back()->with('error', 'Current password does not match.');
        }

        $user->password = Hash::make($request->password);
        $user->plain_password = $request->password;
        $user->save();

        return redirect()->back()->with('success', 'Password changed successfully.');
    }
}

