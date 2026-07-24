<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Global Categories for Header (Shared Across All Pages)
        \Illuminate\Support\Facades\View::composer('layouts.app', function ($view) {
            // We use Cache here to avoid querying the DB on EVERY single page load.
            $categories = \Illuminate\Support\Facades\Cache::remember('header_categories', 3600, function () {
                return \App\Models\Category::with('subCategories')->get();
            });
            $view->with('categories', $categories);
        });

        // Global Settings Composer (Shared Across All Pages)
        \Illuminate\Support\Facades\View::composer('*', function ($view) {
            try {
                $settings = \App\Models\Setting::getAllCached();
                $phone = $settings['support_phone'];
                $email = $settings['support_email'];
                $facebook = $settings['facebook_link'];
                $instagram = $settings['instagram_link'];
                $twitter = $settings['twitter_link'];
                $youtube = $settings['youtube_link'];
                $officeAddress = $settings['office_address'] ?? 'Avenue 7, New Delhi, India 110001';
                
                // Remove spaces, brackets, dashes, plus sign for WhatsApp/telephone links
                $cleanPhone = preg_replace('/[^0-9]/', '', $phone);
                
                $view->with('global_settings', [
                    'support_email' => $email,
                    'support_phone' => $phone,
                    'clean_phone' => $cleanPhone,
                    'facebook_link' => $facebook,
                    'instagram_link' => $instagram,
                    'twitter_link' => $twitter,
                    'youtube_link' => $youtube,
                    'office_address' => $officeAddress,
                ]);
            } catch (\Exception $e) {
                // Fallback to defaults if DB or table does not exist yet (e.g. during migrations)
                $view->with('global_settings', [
                    'support_email' => 'shoppingclubindia1@gmail.com',
                    'support_phone' => '+91 70882 13888',
                    'clean_phone' => '917088213888',
                    'facebook_link' => '#',
                    'instagram_link' => '#',
                    'twitter_link' => '#',
                    'youtube_link' => '#',
                    'office_address' => 'Avenue 7, New Delhi, India 110001',
                ]);
            }
        });
    }
}
