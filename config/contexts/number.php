<?php

declare(strict_types=1);

use ArchPhp\Context\ContextConfigurator;
use Brick\Math\BigInteger;

return function (ContextConfigurator $configurator): void {
    $configurator
        ->register('number', -1)
        ->setVoter(static function (mixed $value): bool {
            return $value instanceof BigInteger || is_int($value);
        })
        ->setFormatter(static function (BigInteger $value): int {
            return $value->toInt();
        })
        ->setInitializer(static function (BigInteger|int $value): BigInteger {
            if ($value instanceof BigInteger) {
                return $value;
            }

            return BigInteger::fromBase((string) $value, 10);
        })
        ->addAssertion('equalsTo', fn(int $expected): bool => $this->isEqualTo($expected))
        ->addAssertion('greaterThan', fn(int $limit): bool => $this->isGreaterThan($limit))
        ->addAssertion('greaterThanOrEqual', fn(int $limit): bool => $this->isGreaterThanOrEqualTo($limit))
        ->addAssertion('lessThan', fn(int $limit): bool => $this->isLessThan($limit))
        ->addAssertion('lessThanOrEqual', fn(int $limit): bool => $this->isLessThanOrEqualTo($limit))
        ->addAssertion('isZero', fn(): bool => $this->isZero())
        ->addAssertion('isNegative', fn(): bool => $this->isZero())
        ->addAssertion('isNegativeOrZero', fn(): bool => $this->isNegativeOrZero())
        ->addAssertion('isPositive', fn(): bool => $this->isPositive())
        ->addAssertion('isPositiveOrZero', fn(): bool => $this->isPositiveOrZero())
    ;
};
