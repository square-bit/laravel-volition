<?php

namespace Squarebit\Volition\Database\Factories;

use Domains\Volition\Tests\Support\TestObject;
use Illuminate\Database\Eloquent\Factories\Factory;
use Squarebit\Volition\Models\Rule;

class RuleFactory extends Factory
{
    protected $model = Rule::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name,
            'applies_to' => TestObject::class,
        ];
    }

    public function forObject(string $class): RuleFactory
    {
        return $this->state(fn (array $attributes) => [
            'applies_to' => $class,
        ]);
    }
}
