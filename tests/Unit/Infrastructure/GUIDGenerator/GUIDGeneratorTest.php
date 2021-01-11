<?php

declare(strict_types=1);

namespace Vasary\XTraceId\Tests\Unit\Infrastructure\GUIDGenerator;

use PHPUnit\Framework\TestCase;
use Vasary\XTraceId\Infrastructure\GUIDGenerator\GUIDGenerator;

final class GUIDGeneratorTest extends TestCase
{
    private const PATTERN = '/^([0-9A-Fa-f]{8}[-][0-9A-Fa-f]{4}[-][0-9A-Fa-f]{4}[-][0-9A-Fa-f]{4}[-][0-9A-Fa-f]{12})$/im';

    /**
     * @test
     */
    public function success(): void
    {
        $generator = new GUIDGenerator();
        $guid = $generator->v4();

        self::assertNotNull($guid);
        self::assertMatchesRegularExpression(self::PATTERN, $guid);
    }
}
