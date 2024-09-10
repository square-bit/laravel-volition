<?php

namespace Squarebit\Volition\Traits;

use ReflectionClass;
use ReflectionParameter;

trait VolitionElement
{
    public static function fromPayload(array $payload): static
    {
        return new static(...$payload);
    }

    public static function getElementType(): string
    {
        return class_basename(static::class);
    }

    public function toPayload(): array
    {
        $reflection = new ReflectionClass(static::class);
        $constructorParams = collect($reflection->getConstructor()?->getParameters())
            ->map(fn (ReflectionParameter $param) => $param->getName())
            ->flip();
        $params = collect((array) $this)
            ->intersectByKeys($constructorParams)
            ->toArray();

        return [
            'type' => static::getElementType(),
            'data' => $params,
        ];
    }
}
