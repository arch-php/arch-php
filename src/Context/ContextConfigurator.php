<?php

declare(strict_types=1);

namespace ArchPhp\Context;

class ContextConfigurator
{
    /**
     * @var array<string, ContextDefinition>
     */
    private array $definitions = [];

    public function register(string $id): ContextDefinition
    {
        return $this->definitions[$id] = new ContextDefinition($id);
    }

    /**
     * @return array<string, ContextDefinition>
     */
    public function all(): array
    {
        return $this->definitions;
    }
}
