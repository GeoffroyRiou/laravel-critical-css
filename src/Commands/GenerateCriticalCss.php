<?php

declare(strict_types=1);

namespace GeoffroyRiou\LaravelCriticalCss\Commands;

use GeoffroyRiou\LaravelCriticalCss\Actions\GenerateCommand\GenerateCriticalCssFileName;
use GeoffroyRiou\LaravelCriticalCss\Actions\GenerateCommand\GenerateCriticalCssFolderPath;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Process;

class GenerateCriticalCss extends Command
{
    protected $signature = 'css:critical}';

    public function handle(
        GenerateCriticalCssFileName $generateFileNameAction,
        GenerateCriticalCssFolderPath $generateFolderPath
    ): void {
        $srcPath = dirname(__DIR__);

        $routes  = config('criticalcss.routes', []);

        $pages = array_map(fn(string $route) => route($route), $routes);

        $nbPages = count($pages);

        $this->info("Generating critical css for " . $nbPages . " pages");

        $this->withProgressBar($pages, function (string $url) use ($srcPath, $generateFileNameAction, $generateFolderPath): void {

            $cssFileName = $generateFileNameAction->execute($url);
            $folderPath = $generateFolderPath->execute();

            $result = Process::run("node $srcPath/generate.mjs --url $url --folder $folderPath --filename $cssFileName");

            if (!empty($result->errorOutput())) {
                $this->error($result->errorOutput());
            }
        });


        $this->line("\n");
        $this->line('<bg=green;> Completed with success !</>');
        $this->line("\n");
    }
}
