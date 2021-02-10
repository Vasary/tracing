<?php

declare(strict_types=1);

namespace Vasary\XTraceId\Tests\Unit\Infrastructure\LoggerProcessor;

use PHPUnit\Framework\TestCase;
use Vasary\XTraceId\Infrastructure\LoggerProcessor\EnvironmentProcessor;


final class EnvironmentProcessorTest extends TestCase
{
    public const TEST_ENV = 'dev';

    /**
     * @test
     */
    public function success(): void
    {
        $fieldName = EnvironmentProcessor::FIELD_NAME;

        $processor = new EnvironmentProcessor(self::TEST_ENV);
        $record = $processor([]);

        self::assertArrayHasKey('extra', $record);
        self::assertArrayHasKey($fieldName, $record['extra']);
        self::assertEquals(self::TEST_ENV, $record['extra'][$fieldName]);
    }
}
