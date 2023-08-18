<?php

namespace Squarebit\Volition\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Squarebit\Volition\Contracts\IsCondition;
use Squarebit\Volition\Models\Condition;

/**
 * @extends Factory<Condition>
 */
class ConditionFactory extends Factory
{
    protected $model = Condition::class;

    public function definition(): array
    {
        return [
            'rule_id' => fn() => RuleFactory::new()->create()->id,
            'active' => true,
        ];
    }

    public function inactive(): ConditionFactory
    {
        return $this->state(fn(array $attributes) => [
            'active' => false,
        ]);
    }

    public function using(IsCondition $condition): ConditionFactory
    {
        return $this->state(fn(array $attributes) => [
            'payload' => $condition,
        ]);
    }
}
