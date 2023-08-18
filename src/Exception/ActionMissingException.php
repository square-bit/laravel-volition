<?php

namespace Squarebit\Volition\Exception;

use Exception;
use Squarebit\Volition\Contracts\IsAction;
use Squarebit\Volition\Contracts\Volitional;

class ActionMissingException extends Exception
{
    /**
     * @param  class-string<\Squarebit\Volition\Contracts\IsAction>  $actionClass
     * @param  class-string<\Squarebit\Volition\Contracts\Volitional>  $objectClass
     */
    public function __construct(string $actionClass, string $objectClass)
    {
        parent::__construct("Action {$actionClass} not applicable on {$objectClass}.");
    }
}
