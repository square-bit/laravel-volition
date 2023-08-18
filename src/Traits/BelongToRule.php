<?php

namespace Squarebit\Volition\Traits;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Squarebit\Volition\Models\Element;
use Squarebit\Volition\Models\Rule;

/**
 * @template TModel
 *
 * @property Rule $rule
 * @property string $rule_id
 */
trait BelongToRule
{
    /**
     * @return BelongsTo<Rule, TModel>
     */
    public function rule(): BelongsTo
    {
        return $this->belongsTo(Rule::class);
    }
}
