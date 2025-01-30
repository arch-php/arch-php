<?php

declare(strict_types=1);

namespace ArchPhp\Context;

use ArchPhp\Assert\Assert;
use Closure;

final readonly class Assertion
{
    /**
     * @param Closure(): bool $callback
     */
    public function __construct(private Closure $callback) {}

    /**
     * @param array<int|string, mixed> $args
     */
    public function call(Context $context, array $args): bool
    {
        Assert::notNull($context->getValue(), 'The context value cannot be null.');

        $callback = $this->callback->bindTo($context->getValue());

        return $callback(...$args);
    }
}
