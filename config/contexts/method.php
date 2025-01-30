<?php

declare(strict_types=1);

use ArchPhp\Context\ContextConfigurator;

return function (ContextConfigurator $configurator): void {
    $configurator
        ->register('method')
        ->setVoter(static function (mixed $value): bool {
            return $value instanceof \ReflectionMethod;
        })
        ->setFormatter(static function (\ReflectionMethod $reflectionMethod): string {
            return $reflectionMethod->getName();
        })
        ->addAssertion('hasReturnType', fn(): bool => $this->hasReturnType())
        ->addAssertion('isAbstract', fn(): bool => $this->isAbstract())
        ->addAssertion('isPrivate', fn(): bool => $this->isPrivate())
        ->addAssertion('isConstructor', fn(): bool => $this->isConstructor())
        ->addAssertion('isDestructor', fn(): bool => $this->isDestructor())
        ->addAssertion('isProtected', fn(): bool => $this->isProtected())
        ->addAssertion('isPublic', fn(): bool => $this->isPublic())
        ->addAssertion('isStatic', fn(): bool => $this->isStatic())
        ->addAssertion(
            'hasParameter',
            fn(string $parameter): bool => [] !== (array_values(
                array_filter(
                    $this->getParameters(),
                    static fn(\ReflectionParameter $reflectionParameter): bool => $reflectionParameter->getName() === $parameter,
                ),
            )),
        )
        ->addAccessor('name', 'string', fn() => $this->getName())
        ->addAccessor('class', 'class', fn() => $this->getDeclaringClass())
        ->addAccessor('returnType', 'type', fn() => $this->getReturnType())
        ->addAccessor('parameters', 'collection[parameter]', fn() => $this->getParameters())
        ->addAccessor(
            'parameter',
            'parameter',
            fn(string $parameter): mixed => [] !== ($parameters = array_values(
                array_filter(
                    $this->getParameters(),
                    static fn(\ReflectionParameter $reflectionParameter): bool => $reflectionParameter->getName() === $parameter,
                ),
            ))
                ? $parameters[0]
                : null,
        )
        ->addAccessor('attributes', 'collection[attribute]', fn() => $this->getAttributes(), )
        ->addAccessor(
            'attribute',
            'attribute',
            fn(string $attribute) => [] !== ($reflectionAttributes = $this->getAttributes($attribute))
                ? $reflectionAttributes[0]
                : null,
        )
    ;
};
