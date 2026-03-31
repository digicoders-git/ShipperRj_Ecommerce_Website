<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        if (Auth::guard('admin')->check()) {
            return redirect()->route('admin.dashboard');
        }
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // 1. Try Admin Guard First
        if (Auth::guard('admin')->attempt($credentials)) {
            return redirect()->route('admin.dashboard');
        }

        // 2. Try SubAdmin Guard Second
        if (Auth::guard('subadmin')->attempt($credentials)) {
            $user = Auth::guard('subadmin')->user();
            
            if (!$user->status) {
                Auth::guard('subadmin')->logout();
                return redirect()->back()->with('error', 'Your sub-admin account is inactive.');
            }

            $user->update(['last_login_at' => now()]);
            return redirect()->route('admin.dashboard');
        }

        // 3. Fallback
        return redirect()->back()->with('error', 'Incorrect email or password.');
    }

    public function logout()
    {
        if (Auth::guard('admin')->check()) {
            Auth::guard('admin')->logout();
        } elseif (Auth::guard('subadmin')->check()) {
            Auth::guard('subadmin')->logout();
        }
        
        return redirect()->route('admin.login');
    }
}

