<?php

namespace Squarebit\Volition\Contracts;

interface IsElement
{
    public static function getElementType(): string;

    /**
     * @param array<string, mixed> $payload
     */
    public static function fromPayload(array $payload): static;

    /**
     * @return array<string, mixed>
     */
    public function toPayload(): array;
}
