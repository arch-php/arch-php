<?php

declare(strict_types=1);

use ArchPhp\Context\ContextConfigurator;

return function (ContextConfigurator $configurator): void {
    $configurator
        ->register('parameter')
        ->setVoter(static function (mixed $value): bool {
            return $value instanceof \ReflectionParameter;
        })
        ->setFormatter(static function (\ReflectionParameter $reflectionParameter): string {
            return $reflectionParameter->getName();
        })
        ->addAssertion('allowsNull', fn(): bool => $this->allowsNull())
        ->addAssertion('canBePassedByValue', fn(): bool => $this->canBePassedByValue())
        ->addAssertion('hasType', fn(): bool => $this->hasType())
        ->addAssertion('isDefaultValueAvailable', fn(): bool => $this->isDefaultValueAvailable())
        ->addAssertion('isOptional', fn(): bool => $this->isOptional())
        ->addAssertion('isPassedByReference', fn(): bool => $this->isPassedByReference())
        ->addAssertion('isPromoted', fn(): bool => $this->isPromoted())
        ->addAssertion('isVariadic', fn(): bool => $this->isVariadic())
        ->addAccessor('name', 'string', fn() => $this->getName())
        ->addAccessor('position', 'number', fn() => $this->getPosition())
        ->addAccessor(
            'method',
            'method',
            fn(): ?\ReflectionMethod => $this->getDeclaringFunction() instanceof \ReflectionMethod
                ? $this->getDeclaringFunction()
                : null,
        )
        ->addAccessor('type', 'type', fn() => $this->getType())
        ->addAccessor('attributes', 'collection[attribute]', fn() => $this->getAttributes())
        ->addAccessor(
            'attribute',
            'attribute',
            fn(string $attribute) => [] !== ($reflectionAttributes = $this->getAttributes($attribute))
                ? $reflectionAttributes[0]
                : null,
        )
    ;
};
