<?php

declare(strict_types=1);

namespace ArchPhp\Tests\Config;

use ArchPhp\Config\ArchPhpConfigBuilder;
use ArchPhp\Rule\Rule;
use PHPUnit\Framework\TestCase;

final class ArchPhpConfigBuilderTest extends TestCase
{
    public function testBuildConfig(): void
    {
        $archPhpConfig = ArchPhpConfigBuilder::configure()
            ->withPaths([dirname(__DIR__) . '/Fixtures'])
            ->skipPath(dirname(__DIR__) . '/Fixtures/Exclude')
            ->withRules([Rule::classes()])
            ->build();

        self::assertNotContains(
            dirname(__DIR__) . '/Fixtures/Exclude/Foo.php',
            $archPhpConfig->getFiles(),
        );

        self::assertCount(1, $archPhpConfig->getRules());
    }

    public function testContextContainer(): void
    {
        $archPhpConfig = ArchPhpConfigBuilder::configure()
            ->withPaths([dirname(__DIR__) . '/Fixtures'])
            ->skipPath(dirname(__DIR__) . '/Fixtures/Exclude')
            ->withRules([Rule::classes()])
            ->build();

        self::assertTrue($archPhpConfig->getContextContainer()->hasDefinition('class'));
        self::assertTrue($archPhpConfig->getContextContainer()->hasDefinition('class_constant'));
        self::assertTrue($archPhpConfig->getContextContainer()->hasDefinition('collection'));
        self::assertTrue($archPhpConfig->getContextContainer()->hasDefinition('enum'));
        self::assertTrue($archPhpConfig->getContextContainer()->hasDefinition('enum_case'));
        self::assertTrue($archPhpConfig->getContextContainer()->hasDefinition('method'));
        self::assertTrue($archPhpConfig->getContextContainer()->hasDefinition('number'));
        self::assertTrue($archPhpConfig->getContextContainer()->hasDefinition('parameter'));
        self::assertTrue($archPhpConfig->getContextContainer()->hasDefinition('property'));
        self::assertTrue($archPhpConfig->getContextContainer()->hasDefinition('string'));
        self::assertTrue($archPhpConfig->getContextContainer()->hasDefinition('type'));
    }
}
