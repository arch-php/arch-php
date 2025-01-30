<?php

declare(strict_types=1);

namespace ArchPhp\Tests\Fixtures;

#[Quux('foo')]
#[Quux('bar')]
final class Foo extends Bar implements Qux, Corge
{
    use Quxxes;

    #[FooBar('baz')]
    public const string FRED = 'fred';

    #[FooBar('baz')]
    public string $quux = 'quux';

    private Bar|Qux $garply;

    private static Bar&Qux $waldo;

    private $fooBar;

    public function __construct() {}

    #[FooBar('baz')]
    public function waldo(#[FooBar('baz')] string $bar): void {}

    protected static function xyzzy($foo): void {}

    protected static function quux() {}
}
