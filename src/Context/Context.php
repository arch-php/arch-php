<?php

declare(strict_types=1);

namespace ArchPhp\Context;

final class Context
{
    /**
     * @var array<string, ?Context>
     */
    private array $accessors = [];

    /**
     * @var array<string, bool>
     */
    private array $assertions = [];

    public function __construct(
        private readonly ContextDefinition $definition,
        private readonly ?object $value,
    ) {}

    public function getFormattedValue(): mixed
    {
        return $this->definition->format($this);
    }

    public function getValue(): ?object
    {
        return $this->value;
    }

    /**
     * @param array<int|string, mixed> $args
     */
    public function access(string $accessor, array $args): ?Context
    {
        if (!isset($this->accessors[$accessor])) {
            $this->accessors[$accessor] = $this->definition->getAccessor($accessor)->call($this, $args);
        }

        return $this->accessors[$accessor];
    }

    public function getDefinition(): ContextDefinition
    {
        return $this->definition;
    }

    public function guessType(): string
    {
        return $this->definition->guessType($this);
    }

    /**
     * @param array<int|string, mixed> $args
     */
    public function assert(string $assertion, array $args): bool
    {
        if (!isset($this->assertions[$assertion])) {
            $this->assertions[$assertion] = $this->definition->getAssertion($assertion)->call($this, $args);
        }

        return $this->assertions[$assertion];
    }
}
