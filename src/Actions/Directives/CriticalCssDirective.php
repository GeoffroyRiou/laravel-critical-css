<?php

namespace GeoffroyRiou\LaravelCriticalCss\Actions\Directives;

use GeoffroyRiou\LaravelCriticalCss\Actions\File\GetCriticalCssFileName;
use Illuminate\Support\Facades\Storage;

class CriticalCssDirective
{

    public function __construct(private readonly GetCriticalCssFileName $generateFileNameAction) {}

    public function execute(): string
    {
        $fileFolder = trim(config('criticalcss.folder', 'critical'), '/');
        $cssFilename = $this->generateFileNameAction->execute(request()->url());
        $cssFilePath = $fileFolder . '/' . $cssFilename;

        $html = '';

        if (Storage::disk(config('criticalcss.disk', 'local'))->exists($cssFilePath)) {

            $fileContent = Storage::disk('local')->get($cssFilePath);
            $fileContent = str_replace("'", "\'", $fileContent);

            $html = "<style><?php echo '$fileContent'; ?></style>";
        }

        return $html;
    }
}
