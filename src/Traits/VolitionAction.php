<?php

namespace Squarebit\Volition\Traits;

use Squarebit\Volition\Facades\Volition;

trait VolitionAction
{
    public static function bootVolitionAction(): void
    {
        Volition::registerActions(static::class);
    }
}
