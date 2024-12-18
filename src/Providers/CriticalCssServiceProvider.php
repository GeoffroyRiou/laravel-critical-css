<?php

namespace GeoffroyRiou\LaravelCriticalCss\Providers;

use GeoffroyRiou\LaravelCriticalCss\Commands\GenerateCriticalCss;

class CriticalCssServiceProvider extends \Illuminate\Support\ServiceProvider
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
        $this->commands([
            GenerateCriticalCss::class,
        ]);
    }
}
