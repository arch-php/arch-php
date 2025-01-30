<?php

declare(strict_types=1);

namespace ArchPhp\Tests\Parser;

use ArchPhp\Parser\PhpParser;
use PhpParser\Node\Stmt;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Finder\SplFileInfo;

final class PhpParserTest extends TestCase
{
    #[TestDox('Test parse PHP files')]
    public function testParse(): void
    {
        $phpParser = new PhpParser();
        $file = new SplFileInfo(__DIR__ . '/../Fixtures/Bar.php', __DIR__ . '/../Fixtures/Bar.php', __DIR__ . '/../Fixtures/Bar.php');
        $statements = $phpParser->parse($file);
        self::assertGreaterThan(0, count($statements));
        self::assertContainsOnlyInstancesOf(Stmt::class, $statements);
    }
}
