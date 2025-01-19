<?php

namespace Squarebit\Volition\Traits;

use Illuminate\Database\Eloquent\Collection;
use Squarebit\Volition\Contracts\IsAction;
use Squarebit\Volition\Exception\ActionMissingException;
use Squarebit\Volition\Models\Action;
use Squarebit\Volition\Models\Rule;

trait HasVolition
{
    protected static ?Collection $allRules = null;

    public static function resetRulesCache(): void
    {
        self::$allRules = null;
    }

    public function allRules(): Collection
    {
        return self::$allRules ??= Rule::with(['conditions', 'actions'])
            ->forClass($this::class)
            ->get();
    }

    /**
     * @return Collection<\Squarebit\Volition\Models\Rule>
     */
    public function rules(): Collection
    {
        return $this->allRules()->filter->passes($this);
    }

    public function rule(string|Rule $rule): ?Rule
    {
        return $rule instanceof Rule
            ? $this->rules()->where('id', $rule->id)->first()
            : $this->rules()->where('name', $rule)->first();
    }

    /**
     * Return all the ActionElements from all passing Rules
     *
     * @return Collection<\Squarebit\Volition\Contracts\IsAction>
     */
    public function actions(string|Rule|null $forRule = null): Collection
    {
        $actions = $forRule
            ? $this->rule($forRule)?->actions
            : new Collection($this->rules()->pluck('actions')->flatten());

        return new Collection(
            $actions
                ?->filter(fn (Action $action): bool => $action->enabled)
                ->pluck('payload')
                ->unique() ?? []
        );
    }

    /**
     * @template TActionClass
     *
     * @param  class-string<TActionClass>  $ofClass
     * @return TActionClass|null
     */
    public function action(string $ofClass, ?string $forRule = null, bool $throw = false): ?IsAction
    {
        $action = $this->actions($forRule)->firstWhere(fn (IsAction $action) => $action instanceof $ofClass);

        throw_if(
            $action === null && $throw,
            ActionMissingException::class,
            $ofClass, $this::class
        );

        return $action;
    }

    /**
     * @param  class-string<\Squarebit\Volition\Contracts\IsAction>  $actionClass
     */
    public function executeAction(string $actionClass, ?string $forRule = null, bool $throw = false): mixed
    {
        return $this->action($actionClass, $forRule, $throw)?->execute($this);
    }
}
