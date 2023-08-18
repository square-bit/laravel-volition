<?php

use Illuminate\Database\Eloquent\Model;
use Squarebit\Volition\Database\Factories\ActionFactory;
use Squarebit\Volition\Database\Factories\ConditionFactory;
use Squarebit\Volition\Database\Factories\RuleFactory;
use Squarebit\Volition\Exception\ActionExecutionException;
use Squarebit\Volition\Exception\ActionMissingException;
use Squarebit\Volition\Models\Rule;
use Squarebit\Volition\Tests\Support\ObjectPropertyCondition;
use Squarebit\Volition\Tests\Support\PrefixAction;
use Squarebit\Volition\Tests\Support\SuffixAction;
use Squarebit\Volition\Tests\Support\TestObject;

beforeEach(function () {
    $condition = new ObjectPropertyCondition(property: 'property', value: 'prop_value');
    $condition2 = new ObjectPropertyCondition(property: 'property', value: 'other_value');
    $condition3 = new ObjectPropertyCondition(property: 'property', value: 'Squarebit');
    $prefixAction = new PrefixAction(prefix: 'Squarebit');
    $suffixAction = new SuffixAction(suffix: 'Squarebit');

    RuleFactory::new(['name' => 'ruleA'])
        ->has(ConditionFactory::new()->using($condition), 'conditions')
        ->has(ActionFactory::new()->using($prefixAction), 'actions')
        ->has(ActionFactory::new()->using($suffixAction), 'actions')
        ->forObject(TestObject::class)
        ->create();

    RuleFactory::new(['name' => 'ruleB'])
        ->has(ConditionFactory::new()->using($condition), 'conditions')
        ->has(ActionFactory::new()->using($suffixAction), 'actions')
        ->forObject(TestObject::class)
        ->create();

    RuleFactory::new(['name' => 'ruleC'])
        ->has(ConditionFactory::new()->using($condition2), 'conditions')
        ->has(ActionFactory::new()->using($prefixAction), 'actions')
        ->forObject(TestObject::class)
        ->create();

    RuleFactory::new(['name' => 'ruleD'])
        ->has(ConditionFactory::new()->using($condition3), 'conditions')
        ->has(ActionFactory::new()->using($prefixAction), 'actions')
        ->forObject(TestObject::class)
        ->create();

    RuleFactory::new(['name' => 'ruleE'])
        ->has(ConditionFactory::new()->using($condition), 'conditions')
        ->has(ActionFactory::new()->using($prefixAction), 'actions')
        ->forObject(Model::class)
        ->create();
});

test('it passes a condition', function () {
    $objA = new TestObject(property: 'prop_value');
    $objB = new TestObject(property: 'other_prop_value');

    expect(Rule::withName('ruleA')->first())
        ->passes($objA)->toBeTrue()
        ->passes($objB)->toBeFalse();
});

test('it gets all rules applicable to object', function () {
    $testObj = new TestObject(property: 'prop_value');

    expect(Rule::all())->toHaveCount(5)
        ->and($testObj->allRules())->toHaveCount(4)
        ->and($testObj->rules())->toHaveCount(2)
        ->and($testObj->actions())->toHaveCount(2)
        ->and($testObj->actions(forRule: 'ruleA'))->toHaveCount(2)
        ->and($testObj->actions(forRule: 'ruleB'))->toHaveCount(1)
        ->and($testObj->action(ofClass: PrefixAction::class))->toBeInstanceOf(PrefixAction::class)
        ->and($testObj->action(ofClass: SuffixAction::class))->toBeInstanceOf(SuffixAction::class);
});

test('it gets no action if none is applicable', function () {
    $testObj = new TestObject(property: 'some_other_prop_value');

    expect($testObj->action(SuffixAction::class))
        ->toBeNull()
        ->and(fn () => $testObj->action(SuffixAction::class, throw: true))
        ->toThrow(ActionMissingException::class);
});

test('it executes actions', function () {
    $testObj = new TestObject(property: 'prop_value');
    $testObj2 = new TestObject(property: 'some_other_prop_value');
    $testObj3 = new TestObject(property: 'Squarebit');

    expect($testObj->executeAction(SuffixAction::class))->toBe('prop_valueSquarebit')
        ->and($testObj2->executeAction(SuffixAction::class))->toBeNull()
        ->and(fn () => $testObj2->executeAction(SuffixAction::class, throw: true))->toThrow(ActionMissingException::class)
        ->and(fn () => $testObj3->executeAction(PrefixAction::class))->toThrow(ActionExecutionException::class);
});
