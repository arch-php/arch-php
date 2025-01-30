<?php

declare(strict_types=1);

namespace ArchPhp\Test;

use ArchPhp\Context\Context;

final readonly class AssertionCase
{
    /**
     * @param array<string, mixed> $arguments
     */
    public function __construct(
        private Context $context,
        private string $assertion,
        private array $arguments,
        private bool $expectedResult,
    ) {}

    public function getResult(): bool
    {
        return $this->context->assert($this->assertion, $this->arguments);
    }

    public function getExpectedResult(): bool
    {
        return $this->expectedResult;
    }

    public function getContext(): Context
    {
        return $this->context;
    }

    public function getAssertion(): string
    {
        return $this->assertion;
    }

    /**
     * @return array<string, mixed>
     */
    public function getArguments(): array
    {
        return $this->arguments;
    }
}
