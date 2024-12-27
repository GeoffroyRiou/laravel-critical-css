<?php

namespace GeoffroyRiou\LaravelCriticalCss\Providers;

use DeferedVite;
use GeoffroyRiou\LaravelCriticalCss\Actions\Directives\CriticalCssDirective;
use \GeoffroyRiou\LaravelCriticalCss\Commands\GenerateCriticalCss;
use Illuminate\Support\Facades\Blade;

class CriticalCssServiceProvider extends \Illuminate\Support\ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(
            \Illuminate\Foundation\Vite::class,
            \GeoffroyRiou\LaravelCriticalCss\Vite\DeferedVite::class
        );
    }

    /**
     * Bootstrap services.
     */
    public function boot(
        CriticalCssDirective $criticalCssDirective
    ): void {
        /**
         * Configuration
         */
        $this->publishes([
            __DIR__ . '/../config/criticalcss.php' => config_path('criticalcss.php'),
        ]);
        $this->mergeConfigFrom(
            __DIR__ . '/../config/criticalcss.php',
            'criticalcss'
        );

        /**
         * Command
         */
        $this->commands([
            GenerateCriticalCss::class,
        ]);

        /**
         * Blade directive
         */
        Blade::directive('criticalCss', fn(string $cssFileUrl) => $criticalCssDirective->execute($cssFileUrl));
    }
}
