<?php

use Squarebit\Volition\Facades\Volition;
use Squarebit\Volition\Tests\Support\ObjectPropertyCondition;
use Squarebit\Volition\Tests\Support\PrefixAction;
use Squarebit\Volition\Tests\Support\SuffixAction;

test('registers Conditions', function () {
    Volition::registerConditions(ObjectPropertyCondition::class);

    expect(Volition::getConditions())->toHaveCount(1);
    expect(Volition::getElement(ObjectPropertyCondition::getElementType()))
        ->toBe(ObjectPropertyCondition::class);
});

test('registers Actions', function () {
    Volition::registerActions([
        PrefixAction::class,
        SuffixAction::class,
    ]);

    expect(Volition::getConditions())->toHaveCount(2);
    expect(Volition::getElement(SuffixAction::getElementType()))
        ->toBe(SuffixAction::class);
});
