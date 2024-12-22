<?php

namespace GeoffroyRiou\LaravelCriticalCss\Providers;

use \GeoffroyRiou\LaravelCriticalCss\Actions\GenerateCommand\GenerateCriticalCssFileName;
use \GeoffroyRiou\LaravelCriticalCss\Commands\GenerateCriticalCss;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Storage;

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
    public function boot(
        GenerateCriticalCssFileName $generateFileNameAction
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
        Blade::directive('criticalCss', function (string $cssFileUrl) use ($generateFileNameAction) {

            $cssFileUrl = trim($cssFileUrl, "'");
            $fileFolder = trim(config('criticalcss.folder', 'critical'), '/');
            $cssFilename = $generateFileNameAction->execute(request()->url());
            $cssFilePath = $fileFolder . '/' . $cssFilename;

            if (Storage::disk('local')->exists($cssFilePath)) {
                $fileContent = Storage::disk('local')->get($cssFilePath);
                return "<style><?php echo '$fileContent'; ?></style>
                <link rel='preload' href='$cssFileUrl' as='style' onload='this.onload=null;this.rel=\"stylesheet\"'>
                <noscript><link rel='stylesheet' href='$cssFileUrl'></noscript>";
            }
        });
    }
}
