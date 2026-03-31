<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function showAuthForm()
    {
        if (Auth::check()) {
            return redirect('/');
        }
        return view('auth');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required', // This can be email or mobile
            'password' => 'required',
        ]);

        $loginInput = $request->email;
        $loginField = filter_var($loginInput, FILTER_VALIDATE_EMAIL) ? 'email' : 'mobile';
        
        $user = User::where($loginField, $loginInput)->first();

        // 1. Check if user exists
        if (!$user) {
            $message = ($loginField === 'email') ? 'This Email is not registered.' : 'This Mobile Number is not registered.';
            return back()->withErrors(['email' => $message])->withInput(['email']);
        }

        // 2. Check if blocked
        if ($user->is_blocked) {
            return back()->withErrors([
                'email' => 'Your account has been blocked by admin. Please contact support.',
            ])->onlyInput('email');
        }

        // 3. Check password explicitly for specific error message
        if (!Hash::check($request->password, $user->password)) {
            return back()->withErrors([
                'email' => 'Incorrect password. Please try again.',
            ])->onlyInput('email');
        }

        // 4. Attempt Login
        if (Auth::attempt([$loginField => $loginInput, 'password' => $request->password], $request->has('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended('/dashboard')->with('success', 'Logged in successfully!');
        }

        return back()->withErrors([
            'email' => 'Unable to login. Please check your credentials.',
        ])->onlyInput('email');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|string|email|max:255|unique:users',
            'mobile' => 'required|string|max:15|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'mobile' => $request->mobile,
                'password' => Hash::make($request->password),
            ]);

            Auth::login($user);

            return redirect('/dashboard')->with('success', 'Account created successfully!');
        } catch (\Exception $e) {
            \Log::error('Registration Error: ' . $e->getMessage());
            return back()->withInput()->withErrors(['error' => 'Something went wrong while creating your account. Please try again.']);
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/')->with('success', 'Logged out successfully.');
    }

    public function checkAuth()
    {
        return response()->json([
            'authenticated' => Auth::check(),
            'user' => Auth::user(),
        ]);
    }
}
