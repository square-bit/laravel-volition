<?php

namespace Squarebit\Volition\Contracts;

use Illuminate\Database\Eloquent\Collection;
use Squarebit\Volition\Models\Rule;

interface Volitional
{
    public static function resetRulesCache(): void;

    public function allRules(): Collection;

    /**
     * @return Collection<\Squarebit\Volition\Models\Rule>
     */
    public function rules(): Collection;

    public function rule(string|Rule $rule): ?Rule;

    /**
     * Return all the ActionElements from all passing Rules
     *
     * @return Collection<\Squarebit\Volition\Contracts\IsAction>
     */
    public function actions(string|Rule|null $forRule = null): Collection;

    /**
     * @template TActionClass
     *
     * @param  class-string<TActionClass>  $ofClass
     * @return TActionClass|null
     */
    public function action(string $ofClass, ?string $forRule = null, bool $throw = false): ?IsAction;

    /**
     * @param  class-string<\Squarebit\Volition\Contracts\IsAction>  $actionClass
     */
    public function executeAction(string $actionClass, ?string $forRule = null, bool $throw = false): mixed;
}
