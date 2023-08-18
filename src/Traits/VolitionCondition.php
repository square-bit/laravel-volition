<?php

namespace Squarebit\Volition\Traits;

use Squarebit\Volition\Facades\Volition;

trait VolitionCondition
{
    public static function bootVolitionCondition(): void
    {
        Volition::registerConditions(static::class);
    }
}
