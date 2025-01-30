<?php

declare(strict_types=1);

namespace ArchPhp\Test\Builder\Context\Type\Reflection;

use ArchPhp\Test\Builder\Context\Type\ReflectionBuilder;

/**
 * @extends ReflectionBuilder<\ReflectionMethod>
 */
final class MethodBuilder extends ReflectionBuilder
{
    public function parameter(string $parameterName): ParameterBuilder
    {
        $parameters = array_combine(
            array_map(static fn($parameter): string => $parameter->getName(), $this->value->getParameters()),
            $this->value->getParameters(),
        );

        return new ParameterBuilder($parameters[$parameterName]);
    }
}
