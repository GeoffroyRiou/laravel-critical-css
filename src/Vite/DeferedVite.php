<?php

namespace GeoffroyRiou\LaravelCriticalCss\Vite;

use Illuminate\Foundation\Vite;

class DeferedVite extends Vite
{

    protected function makeStylesheetTagWithAttributes($url, $attributes)
    {

        if (!$this->shouldUseDeferLoading()) {
            return parent::makeStylesheetTagWithAttributes($url, $attributes);
        }

        $attributes = $this->parseAttributes(array_merge([
            'rel' => 'preload',
            'as' => 'style',
            'href' => $url,
            'nonce' => $this->nonce ?? false,
            'onload' => "this.rel='stylesheet';this.onload=null;console.log('here')",
            'fetchpriority' => 'high'
        ], $attributes));

        return '<link ' . implode(' ', $attributes) . ' />';
    }

    /**
     * Handle preload link generation
     * Returns empty string if defered css loading is active because it is handles elsewhere
     */
    protected function makePreloadTagForChunk($src, $url, $chunk, $manifest)
    {

        if (!$this->shouldUseDeferLoading()) {
            return parent::makePreloadTagForChunk($src, $url, $chunk, $manifest);
        }

        return '';
    }

    private function shouldUseDeferLoading(): bool
    {
        return !env('APP_DEBUG') && config('criticalcss.useViteCssDefer');
    }
}
