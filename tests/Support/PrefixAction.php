<?php

namespace Squarebit\Volition\Tests\Support;

use Squarebit\Volition\Contracts\IsAction;
use Squarebit\Volition\Exception\ActionExecutionException;

/**
 * @template-implements \Squarebit\Volition\Contracts\IsAction<string>
 */
class PrefixAction implements IsAction
{
    public function __construct(
        public string $prefix = ''
    ) {}

    /**
     * @param  TestObject  $object
     */
    public function execute(mixed $object): string
    {
        throw_if($object->property === $this->prefix, ActionExecutionException::class, static::class, $object::class);

        return $this->prefix.$object->property;
    }

    public function __toString(): string
    {
        return __('Prefix').': '.$this->prefix;
    }
}
