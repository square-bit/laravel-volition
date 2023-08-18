<?php

namespace Squarebit\Volition\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Squarebit\Volition\Contracts\IsAction;
use Squarebit\Volition\Contracts\IsCondition;
use Squarebit\Volition\Contracts\Volitional;

/**
 * @property int $id
 * @property string $name
 * @property class-string $applies_to
 * @property Collection<int, Condition> $conditions
 * @property Collection<int, Action> $actions
 *
 * @method static Builder<static> forClass(string $className)
 * @method static Builder<static> withName(string $name)
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

    /**
     * @param  Builder<static>  $query
     * @return Builder<static>
     */
    public function scopeWithName(Builder $query, string $name): Builder
    {
        return $query->where('name', $name);
    }

    /**
     * @param  Builder<static>  $query
     * @param  class-string  $className
     * @return Builder<static>
     */
    public function scopeForClass(Builder $query, string $className): Builder
    {
        return $query->where('applies_to', $className);
    }

    public function passes(Volitional $object): bool
    {
        return $this->conditions
            ->reduce(fn (bool $carry, Condition $condition): bool => $carry && $condition->passes($object), true);
    }

    public function addCondition(IsCondition $condition): static
    {
        $this->conditions()->save((new Condition())->condition($condition));

        return $this;
    }

    public function addAction(IsAction $action): static
    {
        $this->actions()->save((new Action())->action($action));

        return $this;
    }
}
