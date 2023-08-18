<?php

namespace Squarebit\Volition\Traits;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Squarebit\Volition\Models\Rule;

/**
 * @property \Squarebit\Volition\Models\Rule $rule
 * @property string rule_id
 */
trait BelongToRule
{
    public function rule(): BelongsTo
    {
        return $this->belongsTo(Rule::class);
    }
}
