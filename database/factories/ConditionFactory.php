<?php

namespace Squarebit\Volition\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Squarebit\Volition\Contracts\IsCondition;
use Squarebit\Volition\Models\Condition;
use Squarebit\Volition\Tests\Support\TestObject;

/**
 * @extends Factory<Condition>
 */
class ConditionFactory extends Factory
{
    protected $model = Condition::class;

    public function definition(): array
    {
        return [
            'rule_id' => fn () => RuleFactory::new()->forObject(TestObject::class)->create()->id,
            'enabled' => true,
        ];
    }

    public function inactive(): ConditionFactory
    {
        return $this->state(fn (array $attributes) => [
            'enabled' => false,
        ]);
    }

    public function using(IsCondition $condition): ConditionFactory
    {
        return $this->state(fn (array $attributes) => [
            'payload' => $condition,
        ]);
    }
}
