<?php

declare(strict_types=1);

use ArchPhp\Context\ContextConfigurator;

return function (ContextConfigurator $configurator): void {
    $configurator
        ->register('class_constant')
        ->setVoter(static function (mixed $value): bool {
            return $value instanceof \ReflectionClassConstant && !$value instanceof \ReflectionEnumUnitCase;
        })
        ->setFormatter(static function (\ReflectionClassConstant $reflectionClassConstant): string {
            return $reflectionClassConstant->getName();
        })
        ->addAssertion('hasType', fn(): bool => $this->hasType())
        ->addAssertion('isPrivate', fn(): bool => $this->isPrivate())
        ->addAssertion('isProtected', fn(): bool => $this->isProtected())
        ->addAssertion('isPublic', fn(): bool => $this->isPublic())
        ->addAccessor('name', 'string', fn() => $this->getName())
        ->addAccessor('class', 'class', fn() => $this->getDeclaringClass())
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
