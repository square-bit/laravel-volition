<?php

namespace Squarebit\Volition\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use RuntimeException;
use Squarebit\Volition\Contracts\IsAction;
use Squarebit\Volition\Facades\Volition;
use Squarebit\Volition\Traits\BelongToRule;

class Action extends Element
{
    /** @use BelongToRule<Action> */
    use BelongToRule;

    use HasFactory;

    protected $table = 'volition_actions';

    public function action(IsAction $action): static
    {
        throw_unless(
            Volition::getElement($action::getElementType()),
            RuntimeException::class,
            'Trying to use an unregistered Action: '.$action::class
        );

        $this->payload = $action;

        return $this;
    }
}
