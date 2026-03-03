<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
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
        Schema::defaultStringLength(191);

        try {
            if (\Illuminate\Support\Facades\Schema::hasTable('system_infos')) {
                $systemInfos = \App\Models\SystemInfo::where('status', 1)->pluck('value', 'key')->toArray();

                view()->share('system_name', $systemInfos['system_name'] ?? 'ProjectSanjal');
                view()->share('system_logo', isset($systemInfos['system_logo']) ? asset('storage/' . $systemInfos['system_logo']) : null);
            }
        }
        catch (\Exception $e) {
        // Ignore if tables don't exist yet
        }
    }
}
