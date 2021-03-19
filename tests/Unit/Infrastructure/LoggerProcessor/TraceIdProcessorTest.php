<?php

declare(strict_types=1);

namespace Vasary\XTraceId\Tests\Unit\Infrastructure\LoggerProcessor;

use PHPUnit\Framework\TestCase;
use Vasary\XTraceId\Domain\LoggerProcessor\LoggerProcessorInterface;
use Vasary\XTraceId\Domain\Manager\TraceIdManagerInterface;
use Vasary\XTraceId\Domain\ValueObject\TraceId;
use Vasary\XTraceId\Infrastructure\LoggerProcessor\TraceIdProcessor;

final class TraceIdProcessorTest extends TestCase
{
    private const MY_TEST_TRACE_ID = 'my_test_trace';

    /**
     * @test
     */
    public function instanceOf(): void
    {
        $processor = $this->getProcessor('my_field');

        self::assertInstanceOf(LoggerProcessorInterface::class, $processor);
    }

    /**
     * @test
     */
    public function checkTrace(): void
    {
        $processor = $this->getProcessor('return_value');

        $record = $processor([]);

        self::assertArrayHasKey('extra', $record);
        self::assertArrayHasKey('return_value', $record['extra']);
        self::assertEquals(self::MY_TEST_TRACE_ID, $record['extra']['return_value']);
    }

    private function getProcessor(string $generatorFieldName): TraceIdProcessor
    {
        return new TraceIdProcessor($this->getGeneratorMock(), $generatorFieldName);
    }

    private function getGeneratorMock(): TraceIdManagerInterface
    {
        $mock = $this->createMock(TraceIdManagerInterface::class);
        $mock->method('get')->willReturn(new TraceId(self::MY_TEST_TRACE_ID));

        return $mock;
    }
}
