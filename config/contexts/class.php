<?php

declare(strict_types=1);

use ArchPhp\Assert\Assert;
use ArchPhp\Context\ContextConfigurator;

use function ArchPhp\global_class_exists;

return function (ContextConfigurator $configurator): void {
    $configurator
        ->register('class', 254)
        ->setVoter(static function (mixed $value): bool {
            return ($value instanceof \ReflectionClass && !$value instanceof \ReflectionEnum)
                || (is_string($value) && global_class_exists($value, flags: CLASS_FLAG | INTERFACE_FLAG | TRAIT_FLAG));
        })
        ->setFormatter(static function (\ReflectionClass $reflectionClass): string {
            return $reflectionClass->getName();
        })
        ->setInitializer(static function (object|string $objectOfClassName): \ReflectionClass {
            if ($objectOfClassName instanceof \ReflectionClass) {
                return $objectOfClassName;
            }

            if (is_string($objectOfClassName)) {
                Assert::classExists($objectOfClassName, flags: CLASS_FLAG | INTERFACE_FLAG | TRAIT_FLAG);
            }

            return new \ReflectionClass($objectOfClassName);
        })
        ->addAssertion('hasParent', fn(): bool => false !== $this->getParentClass())
        ->addAssertion('hasAttribute', fn(string $attribute): bool => [] !== $this->getAttributes($attribute))
        ->addAssertion('hasProperty', fn(string $property): bool => $this->hasProperty($property))
        ->addAssertion('hasConstant', fn(string $constant): bool => $this->hasConstant($constant))
        ->addAssertion('hasMethod', fn(string $method): bool => $this->hasMethod($method))
        ->addAssertion('implementsInterface', fn(string $interface): bool => $this->implementsInterface($interface))
        ->addAssertion('usesTrait', fn(string $trait): bool => \in_array($trait, $this->getTraitNames(), true))
        ->addAssertion('hasConstructor', fn(): bool => $this->hasMethod('__construct'))
        ->addAssertion('isAbstract', fn(): bool => $this->isAbstract())
        ->addAssertion('isCloneable', fn(): bool => $this->isCloneable())
        ->addAssertion('isFinal', fn(): bool => $this->isFinal())
        ->addAssertion('isInstantiable', fn(): bool => $this->isInstantiable())
        ->addAssertion('isInterface', fn(): bool => $this->isInterface())
        ->addAssertion('isInternal', fn(): bool => $this->isInternal())
        ->addAssertion('isIterable', fn(): bool => $this->isIterable())
        ->addAssertion('isReadOnly', fn(): bool => $this->isReadOnly())
        ->addAssertion('isSubclassOf', fn(string $class): bool => $this->isSubclassOf($class))
        ->addAssertion('isTrait', fn(): bool => $this->isTrait())
        ->addAssertion('isUserDefined', fn(): bool => $this->isUserDefined())
        ->addAssertion('isInNamespace', fn(): bool => $this->inNamespace())
        ->addAccessor('name', 'string', fn() => $this->getName())
        ->addAccessor('shortName', 'string', fn() => $this->getShortName())
        ->addAccessor('namespace', 'string', fn() => $this->getNamespaceName())
        ->addAccessor('properties', 'collection[property]', fn() => $this->getProperties())
        ->addAccessor('property', 'property', fn(string $property) => $this->hasProperty($property) ? $this->getProperty($property) : null)
        ->addAccessor('constants', 'collection[class_constant]', fn() => $this->getReflectionConstants())
        ->addAccessor('constant', 'class_constant', fn(string $constant) => $this->hasConstant($constant) ? $this->getReflectionConstant($constant) : null)
        ->addAccessor('methods', 'collection[method]', fn() => $this->getMethods())
        ->addAccessor('method', 'method', fn(string $method) => $this->hasMethod($method) ? $this->getMethod($method) : null)
        ->addAccessor('attributes', 'collection[attribute]', fn() => $this->getAttributes())
        ->addAccessor(
            'attribute',
            'attribute',
            fn(string $attribute) => [] !== ($reflectionAttributes = $this->getAttributes($attribute))
                ? $reflectionAttributes[0]
                : null,
        )
        ->addAccessor('interfaces', 'collection[class]', fn() => $this->getInterfaces())
        ->addAccessor('traits', 'collection[class]', fn() => $this->getTraits())
        ->addAccessor('parent', 'class', fn() => false !== $this->getParentClass() ? $this->getParentClass() : null)
    ;
};
