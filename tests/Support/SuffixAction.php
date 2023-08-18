<?php

namespace Squarebit\Volition\Tests\Support;

use Squarebit\Volition\Contracts\IsAction;

/**
 * @template-implements \Squarebit\Volition\Contracts\IsAction<string>
 */
class SuffixAction implements IsAction
{
    public function __construct(
        public string $suffix = ''
    ) {
    }

    /**
     * @param  TestObject  $object
     */
    public function execute(mixed $object): string
    {
        return $object->property.$this->suffix;
    }
}
