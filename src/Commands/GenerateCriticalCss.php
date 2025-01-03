<?php

declare(strict_types=1);

namespace GeoffroyRiou\LaravelCriticalCss\Commands;

use GeoffroyRiou\LaravelCriticalCss\Actions\File\GetFileNameAction;
use GeoffroyRiou\LaravelCriticalCss\Actions\File\GetFolderPathAction;
use GeoffroyRiou\LaravelCriticalCss\Actions\Sitemap\ExtractSitemapUrls;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Process;

class GenerateCriticalCss extends Command
{
    protected $signature = 'criticalcss:generate';
    private int $nbErrors = 0;

    public function __construct(private readonly ExtractSitemapUrls $extract)
    {
        parent::__construct();
    }

    public function handle(
        GetFileNameAction $generateFileNameAction,
        GetFolderPathAction $generateFolderPath,
    ): void {

        $pages = array_merge($this->getPagesFromRoutes(), $this->getPagesFromSitemap());

        $nbPages = count($pages);

        $this->info("Generating critical css for " . $nbPages . " pages");

        $this->withProgressBar($pages, function (string $url) use ($generateFileNameAction, $generateFolderPath): void {

            $cssFileName = $generateFileNameAction->execute($url);
            $folderPath = $generateFolderPath->execute();
            $penthouseForceIncludeArguments = $this->getCommandlineArgumentsFromArrayValues('penthouse-forceInclude', config('criticalcss.force_include', []));

            $result = Process::run(" critical $url --base $folderPath  --target $cssFileName --width 1300 --height 900 --ignore-atrule '@font-face' --ignoreInlinedStyles $penthouseForceIncludeArguments ");

            if (!empty($result->errorOutput())) {
                $this->nbErrors++;
                $this->error($result->errorOutput());
            }
        });

        if ($this->nbErrors > 0) {
            $this->line("\n");
            $this->error("<bg=red;> Completed with $this->nbErrors error.s !</>");
            $this->line("\n");
        } else {
            $this->line("\n");
            $this->line('<bg=green;> Completed with success !</>');
            $this->line("\n");
        }
    }

    private function getCommandlineArgumentsFromArrayValues(string $optionName, array $values): string
    {
        return implode(' ', array_map(function ($value) use ($optionName) {
            return "--$optionName '$value'";
        }, $values));
    }


    /**
     * Returns pages
     */
    private function getPagesFromSitemap(): array
    {
        $sitemapPath = config('criticalcss.sitemap_path', null);
        $pages = [];

        if (!empty($sitemapPath)) {
            $pages = $this->extract->execute($sitemapPath);
        }

        return $pages;
    }

    private function getPagesFromRoutes(): array
    {
        $routes = config('criticalcss.route_names', []);

        $pages = [];

        foreach ($routes as $routeName => $data) {
            if (is_int($routeName)) {
                $routeName = $data;
                $data = [];
            }
            $pages[] = route($routeName, $data);
        }

        return $pages;
    }
}
