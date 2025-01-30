<?php

declare(strict_types=1);

use ArchPhp\Context\ContextConfigurator;

return function (ContextConfigurator $configurator): void {
    $configurator
        ->register('type')
        ->setVoter(static function (mixed $value): bool {
            return $value instanceof \ReflectionType;
        })
        ->setFormatter(static function (\ReflectionType $reflectionType): string {
            return $reflectionType->__toString();
        })
        ->addAssertion('allowsNull', fn(): bool => $this->allowsNull())
        ->addAssertion('isNamed', fn(): bool => $this instanceof \ReflectionNamedType)
        ->addAssertion('isBuiltIn', fn(): bool => $this instanceof \ReflectionNamedType && $this->isBuiltin())
        ->addAssertion('isA', fn(string $type): bool => $this instanceof \ReflectionNamedType && $this->getName() === $type)
        ->addAssertion('isClass', fn(): bool => $this instanceof \ReflectionNamedType && \class_exists($this->getName()))
        ->addAssertion('isInterface', fn(): bool => $this instanceof \ReflectionNamedType && \interface_exists($this->getName()))
        ->addAssertion('isEnum', fn(): bool => $this instanceof \ReflectionNamedType && \enum_exists($this->getName()))
        ->addAssertion('isTrait', fn(): bool => $this instanceof \ReflectionNamedType && \trait_exists($this->getName()))
        ->addAssertion('isUnion', fn(): bool => $this instanceof \ReflectionUnionType)
        ->addAssertion('isIntersection', fn(): bool => $this instanceof \ReflectionIntersectionType)
        ->addAccessor(
            'name',
            'string',
            fn() => $this instanceof \ReflectionNamedType ? $this->getName() : null,
        )->addAccessor(
            'class',
            'enum|class',
            fn(): ?\ReflectionClass => (
                !$this instanceof \ReflectionNamedType
                || (
                    !\class_exists($this->getName())
                    && !\interface_exists($this->getName())
                    && !\enum_exists($this->getName())
                    && !\trait_exists($this->getName())
                )
            )
                ? null
                : (\enum_exists($this->getName()) ? new \ReflectionEnum($this->getName()) : new \ReflectionClass($this->getName())),
        )
        ->addAccessor(
            'types',
            'collection[type]',
            fn(): array => (!$this instanceof \ReflectionIntersectionType && !$this instanceof \ReflectionUnionType) ? [] : $this->getTypes(),
        )
    ;
};
