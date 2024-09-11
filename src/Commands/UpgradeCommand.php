<?php

namespace Squarebit\Volition\Commands;

use Illuminate\Console\Command;
use Squarebit\Volition\Models\Action;
use Squarebit\Volition\Models\Condition;
use Squarebit\Volition\Models\Rule;

class UpgradeCommand extends Command
{
    protected $signature = 'volition:upgrade';

    protected $description = 'Performs any necessary upgrade activities';

    public function handle(): void
    {
        Rule::with(['conditions', 'actions'])
            ->get()
            ->each(function (Rule $rule) {
                $rule->conditions->each(function (Condition $condition) {
                    // @phpstan-ignore-next-line
                    $condition->payload;
                    $condition->save();
                });
                $rule->actions->each(function (Action $condition) {
                    // @phpstan-ignore-next-line
                    $condition->payload;
                    $condition->save();
                });
            });
    }
}
