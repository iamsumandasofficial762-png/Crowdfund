<?php

namespace App\Providers;

use App\Models\AdminActivity;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
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
        View::composer('admin.*', function ($view) {
            $cacheData = Cache::remember(
                'admin.activity_bell.summary',
                now()->addSeconds(30),
                function () {
                    if (! Schema::hasTable('admin_activities')) {
                        return [collect(), 0];
                    }

                    return [
                        AdminActivity::latest()->take(5)->get(),
                        AdminActivity::unread()->count(),
                    ];
                }
            );

            // Ensure cache data is valid
            $latestAdminActivities = is_array($cacheData) && isset($cacheData[0]) && is_object($cacheData[0]) 
                ? $cacheData[0] 
                : (is_array($cacheData) && isset($cacheData[0]) ? $cacheData[0] : collect());
            
            $unreadAdminActivityCount = is_array($cacheData) && isset($cacheData[1]) && is_int($cacheData[1]) 
                ? $cacheData[1] 
                : 0;

            // If latestAdminActivities is not a collection, ensure it becomes one
            if (! $latestAdminActivities instanceof \Illuminate\Support\Collection) {
                $latestAdminActivities = collect($latestAdminActivities);
            }

            $view->with(compact('latestAdminActivities', 'unreadAdminActivityCount'));
        });
    }
}
