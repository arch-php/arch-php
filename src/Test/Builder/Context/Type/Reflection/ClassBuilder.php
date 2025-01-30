<?php

declare(strict_types=1);

namespace ArchPhp\Test\Builder\Context\Type\Reflection;

use ArchPhp\Assert\Assert;
use ArchPhp\Test\Builder\Context\Type\ReflectionBuilder;

/**
 * @extends ReflectionBuilder<\ReflectionClass>
 */
final class ClassBuilder extends ReflectionBuilder
{
    public function constant(string $constantName): ClassConstantBuilder
    {
        $constant = $this->value->getReflectionConstant($constantName);

        Assert::isInstanceOf($constant, \ReflectionClassConstant::class);

        return new ClassConstantBuilder($constant);
    }

    public function method(string $methodName): MethodBuilder
    {
        return new MethodBuilder($this->value->getMethod($methodName));
    }

    public function attribute(string $attributeName): AttributeBuilder
    {
        return new AttributeBuilder($this->value->getAttributes($attributeName)[0]);
    }

    public function property(string $propertyName): PropertyBuilder
    {
        return new PropertyBuilder($this->value->getProperty($propertyName));
    }
}
