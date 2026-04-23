<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate; // 1. Add this import at the top
use App\Models\User;
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
        // 2. Define the 'admin' Gate here
        Gate::define('admin', function (User $user) {
            return $user->role === 'admin';
        });
    }
}