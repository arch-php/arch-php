<?php

declare(strict_types=1);

namespace ArchPhp\Tests\Fixtures;

#[Quux('bar')]
enum Grault: string
{
    #[FooBar('foo')]
    case Foo = 'foo';
    case Bar = 'bar';

    public const string FRED = 'fred';

    public function waldo(string $bar): void {}
}
