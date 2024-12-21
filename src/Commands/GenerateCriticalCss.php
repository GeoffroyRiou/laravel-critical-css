<?php

declare(strict_types=1);

namespace GeoffroyRiou\LaravelCriticalCss\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Process;

class GenerateCriticalCss extends Command
{
    protected $signature = 'css:critical}';

    public function handle()
    {
        $srcPath = dirname(__DIR__);

        $pages = [
            route('home'),
        ];

        $nbPages = count($pages);

        $this->info("Generating critical css for " . $nbPages . " pages");

        $this->withProgressBar($pages, function (string $url) use ($srcPath): void {
            
            $cssFileName = preg_replace('#https?://[^/]+/?#', '', $url);
            $cssFileName = str_replace('/', '-', $cssFileName);
            $cssFileName = empty($cssFileName) ? 'index' : $cssFileName;
 
            $result = Process::run("node $srcPath/generate.mjs --url $url --filename $cssFileName");

            if (!empty($result->errorOutput())) {
                $this->error($result->errorOutput());
            }

        });


        $this->line("\n");
        $this->line('<bg=green;> Completed with success !</>');
        $this->line("\n");
    }
}
