<?php

use Squarebit\Volition\Database\Factories\ConditionFactory;
use Squarebit\Volition\Models\Condition;
use Squarebit\Volition\Tests\Support\ObjectPropertyCondition;

beforeEach(function () {
    /** @var \Squarebit\Volition\Models\Condition $conditionElement */
    $this->conditionElement = ConditionFactory::new()->make();
    $this->condition = new ObjectPropertyCondition(property: 'prop_name', value: 'prop_value');

    $this->conditionElement->condition($this->condition);
});

test('it creates a condition', function () {
    expect($this->conditionElement)
        ->save()->toBeTrue();
});

test('it loads a condition', function () {
    $this->conditionElement->save();

    expect(Condition::first()->payload)
        ->toEqual($this->condition);
});
