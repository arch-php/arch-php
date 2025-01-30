<?php

declare(strict_types=1);

namespace ArchPhp\Test\Builder\Context\Type\Reflection;

use ArchPhp\Test\Builder\Context\Type\ReflectionBuilder;

/**
 * @extends ReflectionBuilder<\ReflectionEnum>
 */
final class EnumBuilder extends ReflectionBuilder
{
    public function case(string $caseName): EnumCaseBuilder
    {
        return new EnumCaseBuilder($this->value->getCase($caseName));
    }
}
