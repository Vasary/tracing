<?php

declare(strict_types=1);

namespace Vasary\XTraceId\Tests\Unit\Infrastructure\LoggerProcessor;

use PHPUnit\Framework\TestCase;
use Vasary\XTraceId\Infrastructure\LoggerProcessor\ExtraLevelNameProcessor;

final class ExtraLevelNameProcessorTest extends TestCase
{
    /**
     * @test
     */
    public function success(): void
    {
        $processor = new ExtraLevelNameProcessor();
        $record = $processor(['level_name' => 'info']);

        self::assertArrayHasKey('extra', $record);
        self::assertArrayHasKey('level_name', $record['extra']);
        self::assertEquals('info', $record['extra']['level_name']);
    }

    /**
     * @test
     */
    public function error(): void
    {
        $processor = new ExtraLevelNameProcessor();
        $record = $processor([]);

        self::assertArrayNotHasKey('extra', $record);
    }
}
