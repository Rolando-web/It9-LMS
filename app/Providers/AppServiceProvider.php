<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use Illuminate\Pagination\Paginator;
use Illuminate\Database\Eloquent\Model;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    // protected $redirectTo = '/login';

    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Force HTTPS in production
        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }

        // Prevent lazy loading in production (helps catch N+1 issues)
        Model::preventLazyLoading(!app()->environment('production'));

        // Set max pagination to prevent memory issues
        Paginator::defaultView('pagination::bootstrap-5');
    }
}
