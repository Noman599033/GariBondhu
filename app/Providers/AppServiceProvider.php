<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;

use Illuminate\Pagination\Paginator;

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
        Paginator::useBootstrapFive();

        Gate::define('is_super_admin', function ($user) {
            return $user instanceof \App\Models\Admin && $user->role === 'super_admin';
        });

        Gate::define('is_manager', function ($user) {
            return $user instanceof \App\Models\Admin && in_array($user->role, ['super_admin', 'manager']);
        });

        Gate::define('is_staff', function ($user) {
            return $user instanceof \App\Models\Admin;
        });
    }
}
