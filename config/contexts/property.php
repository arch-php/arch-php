<?php

declare(strict_types=1);

use ArchPhp\Context\ContextConfigurator;

return function (ContextConfigurator $configurator): void {
    $configurator
        ->register('property')
        ->setVoter(static function (mixed $value): bool {
            return $value instanceof \ReflectionProperty;
        })
        ->setFormatter(static function (\ReflectionProperty $reflectionProperty): string {
            return $reflectionProperty->getName();
        })
        ->addAssertion('hasDefaultValue', fn(): bool => $this->hasDefaultValue())
        ->addAssertion('hasType', fn(): bool => $this->hasType())
        ->addAssertion('isDefault', fn(): bool => $this->isDefault())
        ->addAssertion('isPrivate', fn(): bool => $this->isPrivate())
        ->addAssertion('isPromoted', fn(): bool => $this->isPromoted())
        ->addAssertion('isProtected', fn(): bool => $this->isProtected())
        ->addAssertion('isPublic', fn(): bool => $this->isPublic())
        ->addAssertion('isReadOnly', fn(): bool => $this->isReadOnly())
        ->addAssertion('isStatic', fn(): bool => $this->isStatic())
        ->addAccessor('name', 'string', fn() => $this->getName())
        ->addAccessor('class', 'class', fn() => $this->getDeclaringClass())
        ->addAccessor('type', 'type', fn() => $this->getType())
        ->addAccessor('attributes', 'collection[attribute]', fn() => $this->getAttributes())
        ->addAccessor(
            'attribute',
            'attribute',
            fn(string $attribute) => [] !== ($reflectionAttributes = $this->getAttributes($attribute)) ? $reflectionAttributes[0] : null,
        )
    ;
};
