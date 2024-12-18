<?php

declare(strict_types=1);

namespace GeoffroyRiou\LaravelCriticalCss\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Process;

class GenerateCriticalCss extends Command
{
    protected $signature = 'css:critical {pages*}';

    public function handle()
    {
        $srcPath = dirname(__DIR__);

        $result = Process::run('node ' . $srcPath . '/generate.mjs '. implode(' ', $this->argument('pages')));

        if(!empty($result->errorOutput())) {
            $this->error($result->errorOutput());
        }else{
            $this->line($result->output());
        }
    }
}
