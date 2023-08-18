<?php

namespace Squarebit\Volition\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;
use Squarebit\Volition\Contracts\IsAction;
use Squarebit\Volition\Contracts\IsCondition;
use Squarebit\Volition\Models\Element;

/**
 * @implements CastsAttributes<IsCondition|IsAction, IsCondition|IsAction>
 */
class Serialize implements CastsAttributes
{
    /**
     * @return IsCondition|IsAction
     */
    public function get(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        return unserialize($value);
    }

    /**
     * @return string
     */
    public function set(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        return serialize($value);
    }
}
