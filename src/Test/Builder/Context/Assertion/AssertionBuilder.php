<?php

declare(strict_types=1);

namespace ArchPhp\Test\Builder\Context\Assertion;

use ArchPhp\Test\Builder\Context\ContextCase;

final class AssertionBuilder
{
    /**
     * @var array<string, mixed>
     */
    private array $arguments = [];

    public function __construct(private readonly ContextCase $contextCase, private readonly string $assertion) {}

    public function withArgument(string $name, mixed $argument): self
    {
        $this->arguments[$name] = $argument;
        return $this;
    }

    public function toBeFalse(): ContextCase
    {
        return $this->build(false);
    }

    public function toBeTrue(): ContextCase
    {
        return $this->build(true);
    }

    private function build(bool $result): ContextCase
    {
        return $this->contextCase->addAssertion(
            new AssertionCase(
                $this->assertion,
                $this->arguments,
                $result,
            ),
        );
    }
}
