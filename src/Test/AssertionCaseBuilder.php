<?php

declare(strict_types=1);

namespace ArchPhp\Test;

use ArchPhp\Assert\Assert;
use ArchPhp\Context\ContextContainer;

final class AssertionCaseBuilder extends CaseBuilder
{
    private ?string $assertion = null;

    private bool $expectedResult = true;

    /**
     * @var array<string, mixed>
     */
    private array $arguments = [];

    public function withAssertion(string $assertion): self
    {
        $this->assertion = $assertion;
        return $this;
    }

    public function withArgument(string $name, mixed $argument): self
    {
        $this->arguments[$name] = $argument;
        return $this;
    }

    public function expectToBeFalse(): self
    {
        $this->expectedResult = false;
        return $this;
    }

    public function build(ContextContainer $container): AssertionCase
    {
        Assert::notNull($this->assertion, 'The assertion must be set.');
        Assert::notNull($this->value, 'The value must be set.');

        return new AssertionCase(
            $container->createContext($this->value),
            $this->assertion,
            $this->arguments,
            $this->expectedResult,
        );
    }
}
