<?php

use Squarebit\Volition\Database\Factories\RuleFactory;
use Squarebit\Volition\Facades\Volition;
use Squarebit\Volition\Models\Action;
use Squarebit\Volition\Models\Condition;
use Squarebit\Volition\Tests\Support\ObjectPropertyCondition;
use Squarebit\Volition\Tests\Support\PrefixAction;
use Squarebit\Volition\Tests\Support\TestObject;

use function Pest\Laravel\artisan;

beforeEach(function () {
    Volition::registerConditions(ObjectPropertyCondition::class);
    Volition::registerActions(PrefixAction::class);

    $rule = RuleFactory::new()->forObject(TestObject::class)->create();
    Condition::insert([
        'rule_id' => $rule->id,
        'enabled' => 1,
        'payload' => serialize(new ObjectPropertyCondition('some_property', 'some_value')),
    ]);
    Action::insert([
        'rule_id' => $rule->id,
        'enabled' => 1,
        'payload' => serialize(new PrefixAction('some_value')),
    ]);
});

test('it creates a action', function () {
    artisan('volition:upgrade')->run();

    expect(Condition::first()->payload)
        ->toBeInstanceOf(ObjectPropertyCondition::class)
        ->property->toEqual('some_property')
        ->value->toEqual('some_value');

    expect(Action::first()->payload)
        ->toBeInstanceOf(PrefixAction::class)
        ->prefix->toEqual('some_value');
});
