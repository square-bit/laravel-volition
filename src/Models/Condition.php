<?php

namespace Squarebit\Volition\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use RuntimeException;
use Squarebit\Volition\Contracts\IsCondition;
use Squarebit\Volition\Contracts\Volitional;
use Squarebit\Volition\Facades\Volition;
use Squarebit\Volition\Traits\BelongToRule;
use Throwable;

class Condition extends Element
{
    /** @use BelongToRule<Condition> */
    use BelongToRule;

    use HasFactory;

    protected $table = 'volition_conditions';

    /**
     * @throws Throwable
     */
    public function condition(IsCondition $condition): static
    {
        throw_unless(
            Volition::getElement($condition::getElementType()),
            RuntimeException::class,
            'Trying to use an unregistered Condition: '.$condition::class
        );

        $this->payload = $condition;

        return $this;
    }

    public function passes(Volitional $object): bool
    {
        return $this->payload->passes($object);
    }
}
