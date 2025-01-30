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
     * @var array<string, int>
     */
    private array $accessorsCalls = [];

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
        if (!$this->definition->getAccessor($accessor)->isMemoizable()) {
            return $this->definition->getAccessor($accessor)->call($this, $args);
        }

        $name = \sprintf('%s?%s', $accessor, http_build_query($args));

        if (!isset($this->accessors[$name])) {
            $this->accessors[$name] = $this->definition->getAccessor($accessor)->call($this, $args);
            $this->accessorsCalls[$name] = 0;
        }

        $this->accessorsCalls[$name]++;

        return $this->accessors[$name];
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
        $name = \sprintf('%s?%s', $assertion, http_build_query($args));

        if (!isset($this->assertions[$name])) {
            $this->assertions[$name] = $this->definition->getAssertion($assertion)->call($this, $args);
        }

        return $this->assertions[$name];
    }
}
