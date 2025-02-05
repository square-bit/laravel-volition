<?php

namespace Squarebit\Volition\Contracts;

use Illuminate\Database\Eloquent\Collection as DBCollection;
use Illuminate\Support\Collection;
use Squarebit\Volition\Models\Rule;

interface Volitional
{
    public static function resetRulesCache(): void;

    public function allRules(?string $actionClass = null): DBCollection;

    /**
     * @return Collection<Rule>
     */
    public function rules(?string $actionClass = null): DBCollection;

    public function rule(string|Rule $rule, ?string $actionClass = null): ?Rule;

    /**
     * Return all the ActionElements from all passing Rules
     *
     * @return Collection<IsAction>
     */
    public function actions(string|Rule|null $forRule = null, ?string $actionClass = null): Collection;

    /**
     * @template TActionClass
     *
     * @param  class-string<TActionClass>  $ofClass
     * @return TActionClass|null
     */
    public function action(string $ofClass, ?string $forRule = null, bool $throw = false): ?IsAction;

    /**
     * @param  class-string<IsAction>  $actionClass
     */
    public function executeAction(string $actionClass, ?string $forRule = null, bool $throw = false): mixed;
}
