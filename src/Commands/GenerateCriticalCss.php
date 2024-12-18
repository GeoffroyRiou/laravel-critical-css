<?php

declare(strict_types=1);

namespace GeoffroyRiou\LaravelCriticalCss\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class GenerateCriticalCss extends Command
{
    protected $signature = 'css:critical';

    public function handle()
    {
        Log::info('Critical css generated');
    }
}