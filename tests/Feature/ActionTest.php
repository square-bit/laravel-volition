<?php

use Squarebit\Volition\Database\Factories\ActionFactory;
use Squarebit\Volition\Facades\Volition;
use Squarebit\Volition\Models\Action;
use Squarebit\Volition\Models\Rule;
use Squarebit\Volition\Tests\Support\PrefixAction;
use Squarebit\Volition\Tests\Support\SuffixAction;

beforeEach(function () {
    Volition::registerActions([
        PrefixAction::class,
        SuffixAction::class,
    ]);

    /** @var Action $actionElement */
    $this->actionElement = ActionFactory::new()->make();
    $this->action = new PrefixAction(prefix: ' The end');

    $this->actionElement->action($this->action);
});

test('it finds actions of a certain type', function () {
    $this->actionElement->save();

    expect(Action::query()->forType(SuffixAction::class)->count())->toBe(0)
        ->and(Action::query()->forType(PrefixAction::class)->count())->toBe(1);
});

test('it creates a action', function () {
    expect($this->actionElement)
        ->save()->toBeTrue()
        ->and($this->actionElement->rule)->toBeInstanceOf(Rule::class);
});

test('it loads a action', function () {
    $this->actionElement->save();

    expect(Action::first()->payload)
        ->toEqual($this->action);
});
