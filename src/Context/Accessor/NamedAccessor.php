<?php

declare(strict_types=1);

namespace ArchPhp\Context\Accessor;

use ArchPhp\Assert\Assert;
use ArchPhp\Context\Context;
use ArchPhp\Context\ContextContainer;
use ArchPhp\Context\ContextDefinition;

class NamedAccessor extends Accessor
{
    protected ?ContextDefinition $definition = null;

    public function getDefinition(): ContextDefinition
    {
        Assert::notNull($this->definition, 'Accessor not resolved');

        return $this->definition;
    }

    public function compile(ContextContainer $container): void
    {
        parent::compile($container);
        $this->definition = $this->container->getDefinition($this->type);
    }

    protected function createContext(mixed $value): Context
    {
        Assert::notNull($this->definition, 'Accessor not resolved');

        return $this->definition->createContext($value);
    }
}
