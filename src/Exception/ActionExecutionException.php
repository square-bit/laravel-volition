<?php

namespace Squarebit\Volition\Exception;

use Exception;
use Squarebit\Volition\Contracts\IsAction;
use Squarebit\Volition\Contracts\Volitional;

class ActionExecutionException extends Exception
{
    /**
     * @param  class-string<IsAction>  $actionClass
     * @param  class-string<Volitional>  $objectClass
     */
    public function __construct(string $actionClass, string $objectClass)
    {
        parent::__construct("Action {$actionClass} cannot be executed on {$objectClass}.");
    }
}
