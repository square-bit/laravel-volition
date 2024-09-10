<?php

namespace Squarebit\Volition\Models\Queries;

use Illuminate\Database\Eloquent\Builder;
use Squarebit\Volition\Models\Rule;

/**
 * @extends Builder<Rule>
 */
class RuleQuery extends Builder
{
    public function withName(string $name): self
    {
        return $this->where('name', $name);
    }

    public function forClass(string $className): self
    {
        return $this->where('applies_to', $className);
    }
}
