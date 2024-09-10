<?php

namespace Squarebit\Volition\Contracts;

interface IsElement
{
    public static function getElementType(): string;

    public static function fromPayload(array $payload): static;

    public function toPayload(): array;
}
