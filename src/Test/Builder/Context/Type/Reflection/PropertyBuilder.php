<?php

declare(strict_types=1);

namespace ArchPhp\Test\Builder\Context\Type\Reflection;

use ArchPhp\Assert\Assert;
use ArchPhp\Test\Builder\Context\Type\ReflectionBuilder;

/**
 * @extends ReflectionBuilder<\ReflectionProperty>
 */
final class PropertyBuilder extends ReflectionBuilder
{
    public function type(): TypeBuilder
    {
        Assert::notNull($this->value->getType());

        return new TypeBuilder($this->value->getType());
    }
}
