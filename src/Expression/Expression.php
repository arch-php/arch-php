<?php

declare(strict_types=1);

namespace ArchPhp\Expression;

/**
 * @method self that()
 * @method self should()
 * @method self isInstantiable()
 * @method self beFinal()
 */
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
        private readonly string $name,
        private readonly array $arguments,
        private readonly ?Expression $parent,
    ) {}

    /**
     * @param array<string|int, mixed> $arguments
     */
    private function add(string $name, array $arguments): Expression
    {
        $child = new self($name, $arguments, $this);

        $this->children[] = $child;

        if (in_array($name, ['isInstantiable', 'beFinal'], true)) {
            return $this;
        }

        return $child;
    }

    public function end(): Expression
    {
        return $this->parent ?? $this;
    }

    /**
     * @param array<string|int, mixed> $arguments
     */
    public function __call(string $name, array $arguments): Expression
    {
        return $this->add($name, $arguments);
    }

    public function isRoot(): bool
    {
        return !$this->parent instanceof Expression;
    }

    /**
     * @return array{name: string, arguments: array<string|int, mixed>, children: array<array-key, mixed>}
     */
    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'arguments' => $this->arguments,
            'children' => array_map(
                static fn(Expression $child): array => $child->toArray(),
                $this->children,
            ),
        ];
    }
}
