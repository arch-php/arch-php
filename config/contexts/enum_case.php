<?php

declare(strict_types=1);

use ArchPhp\Context\ContextConfigurator;

return function (ContextConfigurator $configurator): void {
    $configurator
        ->register('enum_case')
        ->setVoter(static function (mixed $value): bool {
            return $value instanceof \ReflectionEnumUnitCase;
        })
        ->setFormatter(static function (\ReflectionEnumUnitCase $reflectionEnumCase): string {
            return $reflectionEnumCase->getName();
        })
        ->addAccessor('name', 'string', fn() => $this->getName())
        ->addAccessor('value', 'number|string', fn(): int|string|null => $this instanceof \ReflectionEnumBackedCase ? $this->getBackingValue() : null)
        ->addAccessor('enum', 'enum', fn() => $this->getDeclaringClass())
        ->addAccessor('attributes', 'collection[attribute]', fn() => $this->getAttributes())
        ->addAccessor(
            'attribute',
            'attribute',
            fn(string $attribute) => [] !== ($reflectionAttributes = $this->getAttributes($attribute)) ? $reflectionAttributes[0] : null,
        )
    ;
};
