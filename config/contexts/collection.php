<?php

declare(strict_types=1);

use ArchPhp\Context\Context;
use ArchPhp\Context\ContextConfigurator;
use ArchPhp\Context\ContextContainer;
use loophp\collection\Collection;

return function (ContextConfigurator $configurator): void {
    $configurator
        ->register('collection')
        ->setVoter(static function (mixed $value): bool {
            return is_iterable($value) && is_countable($value);
        })
        ->setFormatter(static function (Collection $collection): array {
            return $collection
                ->map(static fn(Context $item): mixed => $item->getFormattedValue())
                ->all();
        })
        ->setInitializer(static function (Collection|array $value, ContextContainer $container): Collection {
            if ($value instanceof Collection) {
                return $value;
            }

            return Collection::fromIterable(
                array_map(
                    $container->createContext(...),
                    $value,
                ),
            );
        })
        ->addAccessor('count', 'number', fn(): int => count($this))
        ->addAccessor(
            'filter',
            'collection',
            fn(Closure $callback) => $this->filter($callback),
        )
    ;
};
