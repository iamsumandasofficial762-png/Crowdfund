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
            [$latestAdminActivities, $unreadAdminActivityCount] = Cache::remember(
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

            $view->with(compact('latestAdminActivities', 'unreadAdminActivityCount'));
        });
    }
}
