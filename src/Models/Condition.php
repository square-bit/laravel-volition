<?php

namespace Squarebit\Volition\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Squarebit\Volition\Contracts\IsCondition;
use Squarebit\Volition\Contracts\Volitional;
use Squarebit\Volition\Traits\BelongToRule;

class Condition extends Element
{
    /** @use BelongToRule<Condition> */
    use BelongToRule;

    use HasFactory;

    protected $table = 'volition_conditions';

    public function condition(IsCondition $condition): static
    {
        $this->payload = $condition;

        return $this;
    }

    public function passes(Volitional $object): bool
    {
        return $this->payload->passes($object);
    }
}
