<?php

namespace Squarebit\Volition;

use Illuminate\Support\Arr;
use ReflectionClass;
use RuntimeException;
use Squarebit\Volition\Contracts\IsAction;
use Squarebit\Volition\Contracts\IsCondition;
use Throwable;

class Volition
{
    /** @var array<int, class-string<IsCondition>> */
    protected array $conditions = [];

    /** @var array<int, class-string<IsAction>> */
    protected array $actions = [];

    /**
     * @return class-string<IsCondition|IsAction>|null
     *
     * @throws Throwable
     */
    public function getElement(string $elementType, bool $throw = false): ?string
    {
        $payloadClass = $this->conditions[$elementType] ?? $this->actions[$elementType] ?? null;
        throw_if(
            $payloadClass === null && $throw,
            RuntimeException::class,
            'Trying to get an unregistered payload type: '.$elementType
        );

        return $payloadClass;
    }

    /**
     * @return array<int, class-string<IsCondition>>
     */
    public function getConditions(): array
    {
        return $this->conditions;
    }

    /**
     * @return array<int, class-string<IsAction>>
     */
    public function getActions(): array
    {
        return $this->actions;
    }

    /**
     * @param  array<int, class-string<IsCondition>>|class-string<IsCondition>  $conditions
     * @return $this
     */
    public function registerConditions(array|string $conditions): self
    {
        /** @var array<int, class-string<IsCondition>> $conditions */
        $conditions = Arr::wrap($conditions);
        foreach ($conditions as $element) {
            $this->checkClassStringImplements($element, IsCondition::class);
            $this->conditions[$element::getElementType()] = $element;
        }

        return $this;
    }

    /**
     * @param  array<int, class-string<IsAction>>|class-string<IsAction>  $actions
     * @return $this
     */
    public function registerActions(array|string $actions): self
    {
        /** @var array<int, class-string<IsAction>> $actions */
        $actions = Arr::wrap($actions);
        foreach ($actions as $element) {
            $this->checkClassStringImplements($element, IsAction::class);
            $this->actions[$element::getElementType()] = $element;
        }

        return $this;
    }

    protected function checkClassStringImplements(string $className, string $interfaceName): void
    {
        $class = new ReflectionClass($className);
        throw_unless(
            $class->implementsInterface($interfaceName),
            RuntimeException::class,
            $className.' is not an instance of '.$interfaceName
        );
    }
}
