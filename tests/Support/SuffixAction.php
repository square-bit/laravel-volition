<?php

namespace Squarebit\Volition\Tests\Support;

use Squarebit\Volition\Contracts\IsAction;
use Squarebit\Volition\Traits\VolitionElement;

/**
 * @template-implements \Squarebit\Volition\Contracts\IsAction<string>
 */
class SuffixAction implements IsAction
{
    use VolitionElement;

    public function __construct(
        public string $suffix = ''
    ) {}

    /**
     * @param  TestObject  $object
     */
    public function execute(mixed $object): string
    {
        return $object->property.$this->suffix;
    }

    public function __toString(): string
    {
        return __('Suffix').': '.$this->suffix;
    }
}
