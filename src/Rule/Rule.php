<?php

declare(strict_types=1);

namespace ArchPhp\Rule;

use Webmozart\Assert\Assert;

final class Rule
{
    private readonly Expression $root;

    private ?Expression $current;

    public function __construct(string $provider)
    {
        $this->root = new Expression(null, $provider, []);
        $this->current = $this->root;
    }

    /**
     * @param array<string|int, mixed> $arguments
     */
    public static function __callStatic(string $name, array $arguments): self
    {
        return new self($name);
    }

    /**
     * @param array<string|int, mixed> $arguments
     */
    public function __call(string $name, array $arguments): self
    {
        Assert::notNull($this->current);

        $this->current = $this->current->add($name, $arguments);

        return $this;
    }

    public function end(): self
    {
        $this->current = $this->current?->getParent();

        return $this;
    }

    public function getExpression(): Expression
    {
        while ($this->current instanceof Expression) {
            $this->end();
        }

        return $this->root;
    }
}
