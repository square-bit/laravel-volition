<?php

namespace Squarebit\Volition\Traits;

use Illuminate\Database\Eloquent\Collection as DBCollection;
use Illuminate\Support\Collection;
use Squarebit\Volition\Contracts\IsAction;
use Squarebit\Volition\Exception\ActionMissingException;
use Squarebit\Volition\Models\Action;
use Squarebit\Volition\Models\Rule;
use Throwable;

trait HasVolition
{
    protected static ?DBCollection $allRules = null;

    protected static array $rulesHavingAction = [];

    public static function resetRulesCache(): void
    {
        self::$allRules = null;
        self::$rulesHavingAction = [];
    }

    /**
     * @param  class-string<IsAction>|null  $actionClass
     */
    public function allRules(?string $actionClass = null): DBCollection
    {
        return $actionClass
            ? self::$rulesHavingAction[$actionClass] ??= Rule::with(['conditions', 'actions'])
                ->forClass($this::class)
                ->whereHas('actions', fn ($query) => $query
                    ->where('enabled', true)
                    ->where('payload->type', $actionClass::getElementType())
                )
                ->get()
            : self::$allRules ??= Rule::with(['conditions', 'actions'])
                ->forClass($this::class)
                ->get();
    }

    /**
     * @return DBCollection<int, Rule>
     */
    public function rules(?string $actionClass = null): DBCollection
    {
        return $this->allRules($actionClass)->filter->passes($this);
    }

    public function rule(string|Rule $rule, ?string $actionClass = null): ?Rule
    {
        return $rule instanceof Rule
            ? $this->rules($actionClass)->where('id', $rule->id)->first()
            : $this->rules($actionClass)->where('name', $rule)->first();
    }

    /**
     * Return all the ActionElements from all passing Rules
     *
     * @return Collection<IsAction>
     */
    public function actions(string|Rule|null $forRule = null, ?string $actionClass = null): Collection
    {
        $actions = $forRule
            ? $this->rule($forRule, $actionClass)?->actions
            : collect($this->rules($actionClass)->pluck('actions')->flatten());

        return collect(
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
     *
     * @throws Throwable
     */
    public function action(string $ofClass, ?string $forRule = null, bool $throw = false): ?IsAction
    {
        $action = $this->actions($forRule, $ofClass)
            ->firstWhere(fn (IsAction $action) => $action instanceof $ofClass);

        throw_if(
            $action === null && $throw,
            ActionMissingException::class,
            $ofClass, $this::class
        );

        return $action;
    }

    /**
     * @param  class-string<IsAction>  $actionClass
     *
     * @throws Throwable
     */
    public function executeAction(string $actionClass, ?string $forRule = null, bool $throw = false): mixed
    {
        return $this->action($actionClass, $forRule, $throw)?->execute($this);
    }
}
