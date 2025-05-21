<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;
class SettingServiceProvider extends ServiceProvider
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
        View::composer(['layouts.frontend.menu','layouts.frontend.master','layouts.frontend.footer', 'frontend.contact', 'frontend.components.about-us-scale', 'frontend.components.build-scale', 'frontend.components.grow-up-business'], function($view){
            $settings = DB::table('config_settings')->first();
           $services_menu = DB::table('services')
                                    ->where('status', 1)
                                    ->whereNull('deleted_at') // Exclude soft-deleted records
                                    ->get();
            $view->with('settings', $settings)
                    ->with('services_menu', $services_menu);
        });
        
    }
}