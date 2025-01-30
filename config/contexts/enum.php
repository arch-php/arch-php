<?php

declare(strict_types=1);

use ArchPhp\Assert\Assert;
use ArchPhp\Context\ContextConfigurator;

return function (ContextConfigurator $configurator): void {
    $configurator
        ->register('enum')
        ->setVoter(static function (mixed $value): bool {
            return $value instanceof \ReflectionEnum || ($value instanceof \ReflectionClass && $value->isEnum());
        })
        ->setFormatter(static function (\ReflectionEnum $reflectionEnum): string {
            return $reflectionEnum->getName();
        })
        ->setInitializer(static function (object|string $objectOfClassName): \ReflectionEnum {
            if ($objectOfClassName instanceof \ReflectionEnum) {
                return $objectOfClassName;
            }

            if ($objectOfClassName instanceof \ReflectionClass) {
                $objectOfClassName = $objectOfClassName->getName();
            }

            if (is_string($objectOfClassName)) {
                Assert::enumExists($objectOfClassName);
            }

            return new \ReflectionEnum($objectOfClassName);
        })
        ->addAssertion('hasAttribute', fn(string $attribute): bool => [] !== $this->getAttributes($attribute))
        ->addAssertion('hasConstant', fn(string $constant): bool => $this->hasConstant($constant))
        ->addAssertion('hasMethod', fn(string $method): bool => $this->hasMethod($method))
        ->addAssertion('implementsInterface', fn(string $interface): bool => $this->implementsInterface($interface))
        ->addAssertion('isCloneable', fn(): bool => $this->isCloneable())
        ->addAssertion('isInternal', fn(): bool => $this->isInternal())
        ->addAssertion('isUserDefined', fn(): bool => $this->isUserDefined())
        ->addAssertion('isInNamespace', fn(): bool => $this->inNamespace())
        ->addAssertion('isBacked', fn(): bool => $this->isBacked())
        ->addAssertion('hasCase', fn(string $case): bool => $this->hasCase($case))
        ->addAccessor('name', 'string', fn() => $this->getName())
        ->addAccessor('type', 'type', fn() => $this->isBacked() ? $this->getBackingType() : null)
        ->addAccessor('shortName', 'string', fn() => $this->getShortName())
        ->addAccessor('namespace', 'string', fn() => $this->getNamespaceName())
        ->addAccessor('cases', 'collection[enum_case]', fn() => $this->getCases())
        ->addAccessor('case', 'enum_case', fn(string $case) => $this->hasCase($case) ? $this->getCase($case) : null)
        ->addAccessor(
            'constants',
            'collection[class_constant]',
            fn(): array => array_filter($this->getReflectionConstants(), static fn(\ReflectionClassConstant $constant): bool => !$constant->isEnumCase()),
        )
        ->addAccessor(
            'constant',
            'class_constant',
            fn(string $constant) => false !== ($constant = $this->getReflectionConstant($constant))
                ? ($constant->isEnumCase() ? null : $constant)
                : null,
        )
        ->addAccessor('methods', 'collection[method]', fn() => $this->getMethods())
        ->addAccessor('method', 'method', fn(string $method) => $this->getMethod($method))
        ->addAccessor('attributes', 'collection[attribute]', fn() => $this->getAttributes())
        ->addAccessor(
            'attribute',
            'attribute',
            fn(string $attribute) => [] !== ($reflectionAttributes = $this->getAttributes($attribute))
                ? $reflectionAttributes[0]
                : null,
        )
        ->addAccessor(
            'interfaces',
            'collection[class]',
            fn(): array => array_filter(
                $this->getInterfaces(),
                static fn(\ReflectionClass $interface): bool => !\in_array(
                    $interface->getName(),
                    [UnitEnum::class, BackedEnum::class],
                ),
            ),
        )
        ->addAccessor(
            'traits',
            'collection[class]',
            fn() => $this->getTraits(),
        )
    ;
};
