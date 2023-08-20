<?php

namespace Squarebit\Volition\Contracts;

use Squarebit\Volition\Exception\ConditionException;

interface IsCondition
{
    /**
     * @throws ConditionException
     */
    public function validate(Volitional $object, bool $isValid): void;

    public function passes(Volitional $object): bool;

    public function __toString();
}
