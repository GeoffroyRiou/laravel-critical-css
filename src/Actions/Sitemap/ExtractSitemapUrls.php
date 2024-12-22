<?php

namespace GeoffroyRiou\LaravelCriticalCss\Actions\Sitemap;

use Exception;
use Illuminate\Contracts\Filesystem\FileNotFoundException;

class ExtractSitemapUrls
{



    public function execute(string $sitemapPath): array
    {

        if (!file_exists($sitemapPath)) {
            throw new FileNotFoundException($sitemapPath);
        }

        $xml = simplexml_load_file($sitemapPath);

        if ($xml === false) {
            throw new Exception('Couldn\'t load sitemap XML');
        }

        $urls = [];

        foreach ($xml as $url) {

            $urls[] = (string)$url->loc;
        }

        return $urls;
    }
}
