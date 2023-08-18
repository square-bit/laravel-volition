<?php

namespace Squarebit\Volition\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Squarebit\Volition\Contracts\IsAction;
use Squarebit\Volition\Contracts\Volitional;

/**
 * @property string $class
 * @property IsAction $payload
 *
 * @method static Builder<static> forClass(string $class)
 */
class Action extends Element
{
    use HasFactory;

    protected $table = 'volition_actions';

    public function action(IsAction $action): static
    {
        $this->payload = $action;

        return $this;
    }

    public function execute(Volitional $object): mixed
    {
        return $this->payload->execute($object);
    }

    /**
     * @param  Builder<static>  $query
     * @param  class-string<\Squarebit\Volition\Contracts\IsAction>  $class
     * @return Builder<static>
     */
    public function scopeForClass(Builder $query, string $class): Builder
    {
        return $query->where('class', $class);
    }
}
