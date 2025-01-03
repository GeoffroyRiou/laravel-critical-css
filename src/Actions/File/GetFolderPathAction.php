<?php

declare(strict_types=1);

namespace GeoffroyRiou\LaravelCriticalCss\Actions\File;

use Illuminate\Support\Facades\Storage;

class GetFolderPathAction
{
    public function execute(): string
    {

        // Get storage folder path
        $cssFileFolder = Storage::disk(config('criticalcss.disk', 'local'))->path(config('criticalcss.folder', 'critical'));

        // Generating path from laravel project root
        $cssFileFolder = str_replace(app()->basePath(), '', $cssFileFolder);

        // Be sure that no / is at start of string but at end
        $cssFileFolder = trim($cssFileFolder, '/');

        return $cssFileFolder . '/';
    }
}
