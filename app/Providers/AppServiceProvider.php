<?php

namespace App\Providers;

use App\Models\AdminActivity;
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
            $latestAdminActivities = collect();
            $unreadAdminActivityCount = 0;

            if (Schema::hasTable('admin_activities')) {
                $latestAdminActivities = AdminActivity::latest()->take(5)->get();
                $unreadAdminActivityCount = AdminActivity::unread()->count();
            }

            $view->with(compact('latestAdminActivities', 'unreadAdminActivityCount'));
        });
    }
}
