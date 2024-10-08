<?php

namespace Squarebit\Volition\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Squarebit\Volition\Contracts\IsAction;
use Squarebit\Volition\Contracts\IsCondition;
use Squarebit\Volition\Contracts\Volitional;
use Squarebit\Volition\Models\Queries\RuleQuery;

/**
 * @property int $id
 * @property string $name
 * @property class-string $applies_to
 * @property Collection<int, Condition> $conditions
 * @property Collection<int, Action> $actions
 */
class Rule extends Model
{
    use HasFactory;

    protected $table = 'volition_rules';

    protected $guarded = ['id'];

    protected $casts = [
        //
    ];

    /**
     * @return HasMany<Condition>
     */
    public function conditions(): HasMany
    {
        return $this->hasMany(Condition::class);
    }

    /**
     * @return HasMany<Action>
     */
    public function actions(): HasMany
    {
        return $this->hasMany(Action::class);
    }

    public function newEloquentBuilder($query): RuleQuery
    {
        return new RuleQuery($query);
    }

    public function passes(Volitional $object): bool
    {
        return $this->conditions
            ->filter(fn (Condition $condition) => $condition->enabled)
            ->reduce(fn (bool $carry, Condition $condition): bool => $carry && $condition->passes($object), true);
    }

    public function addCondition(IsCondition $condition, bool $enabled = true): static
    {
        $this->conditions()
            ->save((new Condition)->condition($condition)->disabled(! $enabled));

        return $this;
    }

    public function addAction(IsAction $action, bool $enabled = true): static
    {
        $this->actions()
            ->save((new Action)->action($action)->disabled(! $enabled));

        return $this;
    }
}
