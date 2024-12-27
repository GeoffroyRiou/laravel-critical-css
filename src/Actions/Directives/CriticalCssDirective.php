<?php

namespace GeoffroyRiou\LaravelCriticalCss\Actions\Directives;

use GeoffroyRiou\LaravelCriticalCss\Actions\GenerateCommand\GenerateCriticalCssFileName;
use Illuminate\Support\Facades\Storage;

class CriticalCssDirective
{

    public function __construct(private readonly GenerateCriticalCssFileName $generateFileNameAction) {}

    public function execute(string $cssFileUrl): string
    {
        $cssFileUrl = trim($cssFileUrl, "'");
        $fileFolder = trim(config('criticalcss.folder', 'critical'), '/');
        $cssFilename = $this->generateFileNameAction->execute(request()->url());
        $cssFilePath = $fileFolder . '/' . $cssFilename;

        $html = "<link rel='preload' href='$cssFileUrl' as='style' onload='this.onload=null;this.rel=\"stylesheet\"'>
                
                <noscript><link rel='stylesheet' href='$cssFileUrl'></noscript>";

        if (Storage::disk(config('criticalcss.disk', 'local'))->exists($cssFilePath)) {

            $fileContent = Storage::disk('local')->get($cssFilePath);
            $fileContent = str_replace("'", "\'", $fileContent);

            $html .= "
            <style><?php echo '$fileContent'; ?></style>";
        }

        return $html;
    }
}
