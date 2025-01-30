<?php

declare(strict_types=1);

namespace ArchPhp\Test\Builder\Context\Accessor;

final readonly class AccessorCase
{
    /**
     * @param array<string, mixed> $arguments
     */
    public function __construct(
        private string $accessor,
        private array $arguments,
        private string $expectedType,
        private mixed $expectedValue,
    ) {}

    public function getExpectedType(): string
    {
        return $this->expectedType;
    }

    public function getExpectedValue(): mixed
    {
        return $this->expectedValue;
    }

    public function getAccessor(): string
    {
        return $this->accessor;
    }

    /**
     * @return array<string, mixed>
     */
    public function getArguments(): array
    {
        return $this->arguments;
    }
}
