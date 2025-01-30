<?php

declare(strict_types=1);

namespace ArchPhp\Tests\Config;

use ArchPhp\Config\ArchPhpConfigBuilder;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;

final class ArchPhpConfigBuilderTest extends TestCase
{
    #[TestDox('Test build config')]
    public function testBuildConfig(): void
    {
        $archPhpConfig = ArchPhpConfigBuilder::configure()
            ->withPaths([dirname(__DIR__) . '/Fixtures'])
            ->skipPath(dirname(__DIR__) . '/Fixtures/Exclude')
            ->build();

        self::assertNotContains(
            dirname(__DIR__) . '/Fixtures/Exclude/Foo.php',
            $archPhpConfig->getFiles(),
        );
    }

    #[TestDox('Test build config with custom contexts')]
    public function testBuildConfigWithCustomContexts(): void
    {
        $archPhpConfig = ArchPhpConfigBuilder::configure()
            ->withPaths([dirname(__DIR__) . '/Fixtures'])
            ->skipPath(dirname(__DIR__) . '/Fixtures/Exclude')
            ->setContextsDir(dirname(__DIR__) . '/Fixtures/Exclude/config')
            ->build();

        $assertions = $archPhpConfig->getContextContainer()->getDefinition('type')->getAssertions();

        self::assertArrayHasKey('fake', $assertions);
        self::assertCount(11, $assertions);
    }

    #[TestDox('Test context container')]
    public function testContextContainer(): void
    {
        $archPhpConfig = ArchPhpConfigBuilder::configure()
            ->withPaths([dirname(__DIR__) . '/Fixtures'])
            ->skipPath(dirname(__DIR__) . '/Fixtures/Exclude')
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
