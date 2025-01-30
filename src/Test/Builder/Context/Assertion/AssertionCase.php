<?php

declare(strict_types=1);

namespace ArchPhp\Test\Builder\Context\Assertion;

final readonly class AssertionCase
{
    /**
     * @param array<string, mixed> $arguments
     */
    public function __construct(
        private string $assertion,
        private array $arguments,
        private bool $expectedResult,
    ) {}

    public function getExpectedResult(): bool
    {
        return $this->expectedResult;
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
