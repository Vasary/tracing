<?php

declare(strict_types=1);

namespace Vasary\XTraceId\Tests\Unit\Infrastructure\LoggerProcessor;

use PHPUnit\Framework\TestCase;
use Vasary\XTraceId\Infrastructure\LoggerProcessor\ApplicationNameProcessor;

final class ApplicationNameProcessorTest extends TestCase
{
    /**
     * @test
     */
    public function success(): void
    {
        $processor = new ApplicationNameProcessor('app');
        $record = $processor([]);

        self::assertArrayHasKey('extra', $record);
        self::assertArrayHasKey('application', $record['extra']);
        self::assertEquals('app', $record['extra']['application']);
    }
}
