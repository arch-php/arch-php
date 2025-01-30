<?php

declare(strict_types=1);

namespace ArchPhp\Test;

use ArchPhp\Assert\Assert;
use ArchPhp\Context\ContextContainer;

final class AccessorCaseBuilder extends CaseBuilder
{
    private ?string $accessor = null;

    private ?string $expectedType = null;

    private mixed $expectedValue = null;

    /**
     * @var array<string, mixed>
     */
    private array $arguments = [];

    public function withAccessor(string $accessor): self
    {
        $this->accessor = $accessor;
        return $this;
    }

    public function withArgument(string $name, mixed $argument): self
    {
        $this->arguments[$name] = $argument;
        return $this;
    }

    public function expectType(string $expectedType): self
    {
        $this->expectedType = $expectedType;
        return $this;
    }

    public function expectValue(mixed $expectedValue): self
    {
        $this->expectedValue = $expectedValue;
        return $this;
    }

    public function build(ContextContainer $container): AccessorCase
    {
        Assert::notNull($this->accessor, 'The accessor must be set.');
        Assert::notNull($this->expectedType, 'The expected type must be set.');
        Assert::notNull($this->value, 'The value must be set.');

        return new AccessorCase(
            $container->createContext($this->value),
            $this->accessor,
            $this->arguments,
            $this->expectedType,
            $this->expectedValue,
        );
    }
}
