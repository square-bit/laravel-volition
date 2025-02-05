<?php

namespace Squarebit\Volition\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use RuntimeException;
use Squarebit\Volition\Contracts\IsAction;
use Squarebit\Volition\Facades\Volition;
use Squarebit\Volition\Traits\BelongToRule;
use Throwable;

class Action extends Element
{
    /** @use BelongToRule<Action> */
    use BelongToRule;

    use HasFactory;

    protected $table = 'volition_actions';

    /**
     * @throws Throwable
     */
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

    /**
     * @param  Builder<static>  $query
     * @param  class-string<\Squarebit\Volition\Contracts\IsAction>  $class
     * @return Builder<static>
     */
    public function scopeForType(Builder $query, string $class): Builder
    {
        return $query->where('payload->type', $class::getElementType());
    }
}
