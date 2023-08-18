<?php

namespace Squarebit\Volition\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Squarebit\Volition\Volition
 */
class Volition extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Squarebit\Volition\Volition::class;
    }
}
