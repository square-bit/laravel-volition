<?php

namespace Squarebit\Volition\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;
use Squarebit\Volition\Contracts\IsAction;
use Squarebit\Volition\Contracts\IsCondition;
use Squarebit\Volition\Contracts\IsElement;
use Squarebit\Volition\Facades\Volition;
use Throwable;

/**
 * @implements CastsAttributes<IsAction|IsCondition, mixed>
 */
class PayloadCast implements CastsAttributes
{
    /**
     * Cast the given value.
     *
     * @param  array<string, mixed>  $attributes
     */
    public function get(Model $model, string $key, mixed $value, array $attributes): IsAction|IsCondition
    {
        if (str_starts_with($value, 'O:')) {
            // it's a serialized object. Required for backwards compatibility
            return unserialize($value);
        }

        $payload = json_decode($value, true);
        /** @var IsCondition|IsAction $payloadClass */
        $payloadClass = Volition::getElement($payload['type'], throw: true);

        return $payloadClass::fromPayload($payload['data']);
    }

    /**
     * Prepare the given value for storage.
     *
     * @param  array<string, mixed>  $attributes
     *
     * @throws Throwable
     */
    public function set(Model $model, string $key, mixed $value, array $attributes): string
    {
        throw_unless($value instanceof IsElement, parameters: ['Cast error: object must implement IsPayload']);

        /** @var IsElement $value */
        return json_encode($value->toPayload());
    }
}
