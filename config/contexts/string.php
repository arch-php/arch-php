<?php

declare(strict_types=1);

use ArchPhp\Context\ContextConfigurator;
use Symfony\Component\String\UnicodeString;

use function Symfony\Component\String\u;

return function (ContextConfigurator $configurator): void {
    $configurator
        ->register('string')
        ->setVoter(static function (mixed $value): bool {
            return $value instanceof UnicodeString || is_string($value);
        })
        ->setFormatter(static function (UnicodeString $value): string {
            return $value->toString();
        })
        ->setInitializer(static function (\Stringable|string $value): UnicodeString {
            if ($value instanceof UnicodeString) {
                return $value;
            }

            return u((string) $value);
        })
        ->addAssertion('isIdenticalTo', fn(string $expected): bool => $this->equalsTo($expected))
        ->addAssertion('isEmpty', fn(): bool => $this->isEmpty())
        ->addAssertion('contains', fn(string $needle): bool => $this->containsAny($needle))
        ->addAssertion('startsWith', fn(string $prefix): bool => $this->startsWith($prefix))
        ->addAssertion('endsWith', fn(string $suffix): bool => $this->endsWith($suffix))
        ->addAssertion('matchesWith', fn(string $pattern): bool => [] !== $this->match($pattern))
        ->addAccessor('length', 'number', fn() => $this->length())
        ->addAccessor('before', 'string', fn(string $needle) => $this->before($needle))
        ->addAccessor('beforeLast', 'string', fn(string $needle) => $this->beforeLast($needle))
        ->addAccessor('after', 'string', fn(string $needle) => $this->after($needle))
        ->addAccessor('afterLast', 'string', fn(string $needle) => $this->afterLast($needle))
    ;
};
