<?php

namespace Squarebit\Volition\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Squarebit\Volition\Models\Rule;
use Squarebit\Volition\Tests\Support\TestObject;

/**
 * @extends Factory<Rule>
 */
class RuleFactory extends Factory
{
    protected $model = Rule::class;

    public function definition(): array
    {
        return [
            'name' => fake()->name,
        ];
    }

    public function forObject(string $class): RuleFactory
    {
        return $this->state(fn (array $attributes) => [
            'applies_to' => $class,
        ]);
    }
}
