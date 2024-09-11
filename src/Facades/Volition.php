<?php

namespace Squarebit\Volition\Facades;

use Illuminate\Support\Facades\Facade;
use Squarebit\Volition\Contracts\IsAction;
use Squarebit\Volition\Contracts\IsCondition;

/**
 * @method static array getConditions()
 * @method static array getActions()
 * @method static null|string getElement(string $elementType, bool $throw = false)
 * @method static \Squarebit\Volition\Volition registerConditions(array<int, class-string<IsCondition>>|class-string<IsCondition> $conditions)
 * @method static \Squarebit\Volition\Volition registerActions(array<int, class-string<IsAction>>|class-string<IsAction> $actions)
 */
class Volition extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Squarebit\Volition\Volition::class;
    }
}
