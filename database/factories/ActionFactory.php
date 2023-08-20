<?php

namespace Squarebit\Volition\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Squarebit\Volition\Contracts\IsAction;
use Squarebit\Volition\Models\Action;
use Squarebit\Volition\Tests\Support\TestObject;

/**
 * @extends Factory<Action>
 */
class ActionFactory extends Factory
{
    protected $model = Action::class;

    public function definition(): array
    {
        return [
            'rule_id' => fn () => RuleFactory::new()->forObject(TestObject::class)->create()->id,
            'active' => true,
        ];
    }

    public function inactive(): ActionFactory
    {
        return $this->state(fn (array $attributes) => [
            'active' => false,
        ]);
    }

    public function using(IsAction $action): ActionFactory
    {
        return $this->state(fn (array $attributes) => [
            'payload' => $action,
        ]);
    }
}
