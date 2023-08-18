<?php

namespace Squarebit\Volition\Contracts;

interface IsAction
{
    public function execute(Volitional $object): mixed;
}
