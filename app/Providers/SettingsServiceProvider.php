<?php

namespace App\Providers;

use App\Models\Setting;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Schema;

class SettingsServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Only share settings if the settings table exists
        if (Schema::hasTable('settings')) {
            $storeSettings = [
                'store_name' => Setting::get('store_name', 'Toko Budi'),
                'store_icon' => Setting::get('store_icon'),
            ];
            
            // Share with all views
            View::share('storeSettings', $storeSettings);
        }
    }
}
