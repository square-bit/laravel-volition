<?php

namespace Squarebit\Volition\Contracts;

interface IsAction extends IsElement
{
    public function execute(Volitional $object): mixed;

    public function __toString();
}
