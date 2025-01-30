<?php

declare(strict_types=1);

namespace ArchPhp\Test\Builder\Context;

use ArchPhp\Test\Builder\Context\Accessor\AccessorBuilder;
use ArchPhp\Test\Builder\Context\Accessor\AccessorCase;
use ArchPhp\Test\Builder\Context\Assertion\AssertionBuilder;
use ArchPhp\Test\Builder\Context\Assertion\AssertionCase;

final class ContextCase
{
    /**
     * @var AccessorCase[]
     */
    private array $accessors = [];

    /**
     * @var AssertionCase[]
     */
    private array $assertions = [];

    public function __construct(private readonly mixed $value) {}

    public function addAssertion(AssertionCase $assertion): self
    {
        $this->assertions[] = $assertion;

        return $this;
    }

    public function assert(string $assertion): AssertionBuilder
    {
        return new AssertionBuilder($this, $assertion);
    }

    public function addAccessor(AccessorCase $accessor): self
    {
        $this->accessors[] = $accessor;

        return $this;
    }

    public function access(string $accessor): AccessorBuilder
    {
        return new AccessorBuilder($this, $accessor);
    }

    public function getValue(): mixed
    {
        return $this->value;
    }

    /**
     * @return AccessorCase[]
     */
    public function getAccessors(): array
    {
        return $this->accessors;
    }

    /**
     * @return AssertionCase[]
     */
    public function getAssertions(): array
    {
        return $this->assertions;
    }
}
