<?php

declare(strict_types=1);

namespace ArchPhp\Context;

use ArchPhp\Assert\Assert;

class ContextConfigurator
{
    /**
     * @var array<string, ContextDefinition>
     */
    private array $definitions = [];

    public function register(string $id, int $priority = 0): ContextDefinition
    {
        return $this->definitions[$id] = new ContextDefinition($id, $priority);
    }

    /**
     * @return array<string, ContextDefinition>
     */
    public function all(): array
    {
        return $this->definitions;
    }

    public function get(string $id): ContextDefinition
    {
        Assert::keyExists($this->definitions, $id, \sprintf('Context "%s" is not registered.', $id));

        return $this->definitions[$id];
    }
}
