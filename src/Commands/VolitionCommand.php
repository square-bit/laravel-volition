<?php

namespace Squarebit\Volition\Commands;

use Illuminate\Console\Command;

class VolitionCommand extends Command
{
    public $signature = 'laravel-volition';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
