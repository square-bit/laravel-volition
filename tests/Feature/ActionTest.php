<?php

use Squarebit\Volition\Database\Factories\ActionFactory;
use Squarebit\Volition\Models\Action;
use Squarebit\Volition\Models\Rule;
use Squarebit\Volition\Tests\Support\PrefixAction;
use Squarebit\Volition\Tests\Support\SuffixAction;

beforeEach(function () {
    /** @var Action $actionElement */
    $this->actionElement = ActionFactory::new()->make();
    $this->action = new PrefixAction(prefix: ' The end');

    $this->actionElement->action($this->action);
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

test('it gets an Action of specific class', function () {
    $this->actionElement->save();

    expect(Action::forClass(PrefixAction::class)->first()->payload)->toEqual($this->action)
        ->and(Action::forClass(SuffixAction::class)->first())->toBeNull();
});
