<?php

declare(strict_types=1);

namespace ArchPhp\Tests\Context\Reflection;

use ArchPhp\Test\AccessorCaseBuilder;
use ArchPhp\Test\AssertionCaseBuilder;
use ArchPhp\Test\ContextTestCase;
use ArchPhp\Tests\Fixtures\Bar;
use ArchPhp\Tests\Fixtures\Baz;
use ArchPhp\Tests\Fixtures\Corge;
use ArchPhp\Tests\Fixtures\Foo;
use ArchPhp\Tests\Fixtures\Quux;
use ArchPhp\Tests\Fixtures\Qux;
use ArchPhp\Tests\Fixtures\Quxxes;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Group;

final class ClassContextTest extends ContextTestCase
{
    /**
     * @return iterable<string, array{AccessorCaseBuilder}>
     */
    public static function provideAccessors(): iterable
    {
        yield 'name' => [
            AccessorCaseBuilder::createClass(Foo::class)
                ->withAccessor('name')
                ->expectType('string')
                ->expectValue(Foo::class),
        ];
        yield 'shortName' => [
            AccessorCaseBuilder::createClass(Foo::class)
                ->withAccessor('shortName')
                ->expectType('string')
                ->expectValue('Foo'),
        ];
        yield 'namespace' => [
            AccessorCaseBuilder::createClass(Foo::class)
                ->withAccessor('namespace')
                ->expectType('string')
                ->expectValue('ArchPhp\Tests\Fixtures'),
        ];
        yield 'interfaces' => [
            AccessorCaseBuilder::createClass(Foo::class)
                ->withAccessor('interfaces')
                ->expectType('collection[class]')
                ->expectValue([
                    Baz::class,
                    Qux::class,
                    Corge::class,
                ]),
        ];
        yield 'traits' => [
            AccessorCaseBuilder::createClass(Foo::class)
                ->withAccessor('traits')
                ->expectType('collection[class]')
                ->expectValue([Quxxes::class]),
        ];
        yield 'attributes' => [
            AccessorCaseBuilder::createClass(Foo::class)
                ->withAccessor('attributes')
                ->expectType('collection[attribute]')
                ->expectValue([Quux::class, Quux::class]),
        ];
        yield 'attribute' => [
            AccessorCaseBuilder::createClass(Foo::class)
                ->withAccessor('attribute')
                ->withArgument('attribute', Quux::class)
                ->expectType('attribute')
                ->expectValue(Quux::class),
        ];
        yield 'properties' => [
            AccessorCaseBuilder::createClass(Foo::class)
                ->withAccessor('properties')
                ->expectType('collection[property]')
                ->expectValue(['quux', 'garply', 'waldo', 'fooBar', 'grault']),
        ];
        yield 'property' => [
            AccessorCaseBuilder::createClass(Foo::class)
                ->withAccessor('property')
                ->withArgument('property', 'quux')
                ->expectType('property')
                ->expectValue('quux'),
        ];
        yield 'constants' => [
            AccessorCaseBuilder::createClass(Foo::class)
                ->withAccessor('constants')
                ->expectType('collection[class_constant]')
                ->expectValue(['FRED', 'PLUGH']),
        ];
        yield 'constant' => [
            AccessorCaseBuilder::createClass(Foo::class)
                ->withAccessor('constant')
                ->withArgument('constant', 'FRED')
                ->expectType('class_constant')
                ->expectValue('FRED'),
        ];
        yield 'methods' => [
            AccessorCaseBuilder::createClass(Foo::class)
                ->withAccessor('methods')
                ->expectType('collection[method]')
                ->expectValue(['__construct', 'waldo', 'xyzzy', 'quux', 'bar', 'baz', 'qux', 'thud', 'foo']),
        ];
        yield 'method' => [
            AccessorCaseBuilder::createClass(Foo::class)
                ->withAccessor('method')
                ->withArgument('method', 'waldo')
                ->expectType('method')
                ->expectValue('waldo'),
        ];
        yield 'parent' => [
            AccessorCaseBuilder::createClass(Foo::class)
                ->withAccessor('parent')
                ->expectType('class')
                ->expectValue(Bar::class),
        ];
    }

    #[DataProvider('provideAccessors')]
    #[Group('accessors')]
    public function testAccessors(AccessorCaseBuilder $accessorCaseBuilder): void
    {
        $this->assertAccessor($accessorCaseBuilder);
    }

    /**
     * @return iterable<string, array{AssertionCaseBuilder}>
     */
    public static function provideAssertions(): iterable
    {
        yield 'hasParent' => [
            AssertionCaseBuilder::createClass(Foo::class)
                ->withAssertion('hasParent'),
        ];
        yield 'hasConstructor' => [
            AssertionCaseBuilder::createClass(Foo::class)
                ->withAssertion('hasConstructor'),
        ];
        yield 'isAbstract' => [
            AssertionCaseBuilder::createClass(Foo::class)
                ->withAssertion('isAbstract')
                ->expectToBeFalse(),
        ];
        yield 'isCloneable' => [
            AssertionCaseBuilder::createClass(Foo::class)
                ->withAssertion('isCloneable'),
        ];
        yield 'isFinal' => [
            AssertionCaseBuilder::createClass(Foo::class)
                ->withAssertion('isFinal'),
        ];
        yield 'isInstantiable' => [
            AssertionCaseBuilder::createClass(Foo::class)
                ->withAssertion('isInstantiable'),
        ];
        yield 'isInterface' => [
            AssertionCaseBuilder::createClass(Foo::class)
                ->withAssertion('isInterface')
                ->expectToBeFalse(),
        ];
        yield 'isInternal' => [
            AssertionCaseBuilder::createClass(Foo::class)
                ->withAssertion('isInternal')
                ->expectToBeFalse(),
        ];
        yield 'isIterable' => [
            AssertionCaseBuilder::createClass(Foo::class)
                ->withAssertion('isIterable')
                ->expectToBeFalse(),
        ];
        yield 'isReadOnly' => [
            AssertionCaseBuilder::createClass(Foo::class)
                ->withAssertion('isReadOnly')
                ->expectToBeFalse(),
        ];
        yield 'isTrait' => [
            AssertionCaseBuilder::createClass(Foo::class)
                ->withAssertion('isTrait')
                ->expectToBeFalse(),
        ];
        yield 'isUserDefined' => [
            AssertionCaseBuilder::createClass(Foo::class)
                ->withAssertion('isUserDefined'),
        ];
        yield 'isInNamespace' => [
            AssertionCaseBuilder::createClass(Foo::class)
                ->withAssertion('isInNamespace'),
        ];
        yield 'hasAttribute' => [
            AssertionCaseBuilder::createClass(Foo::class)
                ->withAssertion('hasAttribute')
                ->withArgument('attribute', Quux::class),
        ];
        yield 'hasProperty' => [
            AssertionCaseBuilder::createClass(Foo::class)
                ->withAssertion('hasProperty')
                ->withArgument('property', 'quux'),
        ];
        yield 'hasConstant' => [
            AssertionCaseBuilder::createClass(Foo::class)
                ->withAssertion('hasConstant')
                ->withArgument('constant', 'FRED'),
        ];
        yield 'hasMethod' => [
            AssertionCaseBuilder::createClass(Foo::class)
                ->withAssertion('hasMethod')
                ->withArgument('method', 'waldo'),
        ];
        yield 'implementsInterface' => [
            AssertionCaseBuilder::createClass(Foo::class)
                ->withAssertion('implementsInterface')
                ->withArgument('interface', Baz::class),
        ];
        yield 'usesTrait' => [
            AssertionCaseBuilder::createClass(Foo::class)
                ->withAssertion('usesTrait')
                ->withArgument('trait', Quxxes::class),
        ];
        yield 'isSubclassOf' => [
            AssertionCaseBuilder::createClass(Foo::class)
                ->withAssertion('isSubclassOf')
                ->withArgument('class', Bar::class),
        ];
    }

    #[DataProvider('provideAssertions')]
    #[Group('assertions')]
    public function testAssertions(AssertionCaseBuilder $assertionCaseBuilder): void
    {
        $this->assertAssertion($assertionCaseBuilder);
    }
}
