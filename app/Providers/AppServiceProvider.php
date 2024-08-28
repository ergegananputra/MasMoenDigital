<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Spatie\Sitemap\SitemapServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
        $this->app->register(SitemapServiceProvider::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
