<?php

namespace Squarebit\Volition\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Squarebit\Volition\Contracts\IsAction;
use Squarebit\Volition\Models\Action;

class ActionFactory extends Factory
{
    protected $model = Action::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'rule_id' => fn () => RuleFactory::new()->create()->id,
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
