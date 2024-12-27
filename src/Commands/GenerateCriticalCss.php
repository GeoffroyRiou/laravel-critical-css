<?php

declare(strict_types=1);

namespace GeoffroyRiou\LaravelCriticalCss\Commands;

use GeoffroyRiou\LaravelCriticalCss\Actions\File\GetCriticalCssFileName;
use GeoffroyRiou\LaravelCriticalCss\Actions\File\GetCriticalCssFolderPath;
use GeoffroyRiou\LaravelCriticalCss\Actions\Sitemap\ExtractSitemapUrls;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Process;

class GenerateCriticalCss extends Command
{
    protected $signature = 'css:critical';

    public function __construct(private readonly ExtractSitemapUrls $extract)
    {
        parent::__construct();
    }

    public function handle(
        GetCriticalCssFileName $generateFileNameAction,
        GetCriticalCssFolderPath $generateFolderPath,
    ): void {

        $srcPath = dirname(__DIR__);

        $pages = array_merge($this->getPagesFromRoutes(), $this->getPagesFromSitemap());

        $nbPages = count($pages);

        $this->info("Generating critical css for " . $nbPages . " pages");

        $this->withProgressBar($pages, function (string $url) use ($srcPath, $generateFileNameAction, $generateFolderPath): void {

            $cssFileName = $generateFileNameAction->execute($url);
            $folderPath = $generateFolderPath->execute();
            $forceInclude = implode(',', config('criticalcss.force_include', []));

            $result = Process::run("node $srcPath/generate.mjs --url $url --folder $folderPath --filename $cssFileName --forceInclude $forceInclude");

            if (!empty($result->errorOutput())) {
                $this->error($result->errorOutput());
            }
        });


        $this->line("\n");
        $this->line('<bg=green;> Completed with success !</>');
        $this->line("\n");
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
