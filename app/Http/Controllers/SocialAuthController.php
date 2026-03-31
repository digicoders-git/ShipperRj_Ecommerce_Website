<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\Cart;

class SocialAuthController extends Controller
{
    /**
     * Redirect the user to the Google authentication page.
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Obtain the user information from Google.
     */
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            
            // Check if a user with this email or google_id already exists
            $user = User::where('google_id', $googleUser->id)
                        ->orWhere('email', $googleUser->email)
                        ->first();

            if ($user) {
                // If user exists but doesn't have a google_id (registered via email previously)
                if (!$user->google_id) {
                    $user->update(['google_id' => $googleUser->id]);
                }
                
                Auth::login($user, true);
            } else {
                // Determine a unique ID if using HasCustomId trait or rely on Eloquent events
                
                // Create a new user
                $user = User::create([
                    'name' => $googleUser->name,
                    'email' => $googleUser->email,
                    'google_id' => $googleUser->id,
                    'password' => null, // Password is null since they authenticated via Google
                ]);

                // Assuming ID mapping is handled automatically by Model Events (like your custom HasCustomId trait)
                Auth::login($user, true);
            }

            // Optional: Move Session cart to Database Cart if applicable in your project
            // Controller logic for transferring session cart can go here
            
            return redirect()->intended('/')->with('success', 'Logged in successfully with Google!');

        } catch (\Exception $e) {
            \Log::error('Google Login Error: ' . $e->getMessage());
            return redirect('/auth')->with('error', 'Authentication failed. Please try again.');
        }
    }
}
