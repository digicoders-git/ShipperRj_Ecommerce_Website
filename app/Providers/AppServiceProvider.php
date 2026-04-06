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
    }
}
