<?php

declare(strict_types=1);

namespace GeoffroyRiou\LaravelCriticalCss\Actions;

class GenerateCriticalCssFileName
{
    public function execute(string $url): string
    {
        // Remove protocol and domain name
        $cssFileName = preg_replace('#https?://[^/]+/?#', '', $url);
        $cssFileName = str_replace('/', '-', $cssFileName);
        // If url is / then index
        $cssFileName = empty($cssFileName) ? 'index' : $cssFileName;
        // Extension
        $cssFileName .= '.critical.css';

        return $cssFileName;
    }
}
