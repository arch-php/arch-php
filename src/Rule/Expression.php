<?php

declare(strict_types=1);

namespace ArchPhp\Rule;

final class Expression
{
    /**
     * @var Expression[]
     */
    private array $children = [];

    /**
     * @param array<string|int, mixed> $arguments
     */
    public function __construct(
        private readonly ?Expression $parent,
        private readonly string $name,
        private readonly array $arguments,
    ) {}

    /**
     * @param array<string|int, mixed> $arguments
     */
    public function add(string $name, array $arguments): Expression
    {
        $child = new self($this, $name, $arguments);

        $this->children[] = $child;

        if (\in_array($name, ['startsWith', 'endsWith', 'isIdenticalTo', 'hasMethod'], true)) {
            return $this;
        }

        return $child;
    }

    public function getParent(): ?Expression
    {
        return $this->parent;
    }

    /**
     * @return Expression[]
     */
    public function getChildren(): array
    {
        return $this->children;
    }

    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return array<string|int, mixed>
     */
    public function getArguments(): array
    {
        return $this->arguments;
    }
}
