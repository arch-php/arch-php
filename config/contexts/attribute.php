<?php

declare(strict_types=1);
use ArchPhp\Context\ContextConfigurator;

return function (ContextConfigurator $configurator): void {
    $configurator
        ->register('attribute')
        ->setVoter(static function (mixed $value): bool {
            return $value instanceof \ReflectionAttribute;
        })
        ->setFormatter(static function (\ReflectionAttribute $reflectionAttribute): string {
            return $reflectionAttribute->getName();
        })
        ->addAssertion('isRepeated', fn(): bool => $this->isRepeated())
        ->addAssertion('isRepeatable', fn(): bool => ($this->getTarget() | \Attribute::IS_REPEATABLE) >= \Attribute::IS_REPEATABLE)
        ->addAssertion('targetClass', fn(): bool => ($this->getTarget() & \Attribute::TARGET_CLASS) === 1)
        ->addAssertion('targetFunction', fn(): bool => ($this->getTarget() & \Attribute::TARGET_FUNCTION) === 1)
        ->addAssertion('targetMethod', fn(): bool => ($this->getTarget() & \Attribute::TARGET_METHOD) === 1)
        ->addAssertion('targetProperty', fn(): bool => ($this->getTarget() & \Attribute::TARGET_PROPERTY) === 1)
        ->addAssertion('targetConstant', fn(): bool => ($this->getTarget() & \Attribute::TARGET_CLASS_CONSTANT) === 1)
        ->addAssertion('targetParameter', fn(): bool => ($this->getTarget() & \Attribute::TARGET_PARAMETER) === 1)
        ->addAssertion('targetAll', fn(): bool => ($this->getTarget() & \Attribute::TARGET_ALL) === \Attribute::TARGET_ALL)
        ->addAccessor('class', 'class', fn(): \ReflectionClass => new \ReflectionClass($this->getName()))
    ;
};
