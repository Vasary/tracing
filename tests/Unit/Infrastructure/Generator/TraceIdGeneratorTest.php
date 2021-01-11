<?php

declare(strict_types=1);

namespace Vasary\XTraceId\Tests\Unit\Infrastructure\Generator;

use PHPUnit\Framework\TestCase;
use Vasary\XTraceId\Domain\Generator\TraceIdGeneratorInterface;
use Vasary\XTraceId\Domain\GUIDGenerator\GUIDGeneratorInterface;
use Vasary\XTraceId\Infrastructure\Generator\TraceIdGenerator;

final class TraceIdGeneratorTest extends TestCase
{
    /**
     * @test
     */
    public function instanceOf(): void
    {
        $traceIdGenerator = new TraceIdGenerator($this->getGeneratorMock(1));

        self::assertInstanceOf(TraceIdGeneratorInterface::class, $traceIdGenerator);
    }

    /**
     * @test
     */
    public function exists(): void
    {
        $traceIdGenerator = new TraceIdGenerator($this->getGeneratorMock(1));

        self::assertNotEmpty($traceIdGenerator->get());
    }

    /**
     * @test
     */
    public function set(): void
    {
        $traceIdGenerator = new TraceIdGenerator($this->getGeneratorMock(1));

        $traceIdGenerator->set('my_trace');

        self::assertEquals('my_trace', $traceIdGenerator->get());
    }

    /**
     * @test
     */
    public function reset(): void
    {
        $traceIdGenerator = new TraceIdGenerator($this->getGeneratorMock(2));

        $initiatedTraceId = $traceIdGenerator->get();
        $traceIdGenerator->reset();
        $afterResetTraceId = $traceIdGenerator->get();

        self::assertNotEmpty($initiatedTraceId);
        self::assertNotEquals($initiatedTraceId, $afterResetTraceId);
    }
    
    private function getGeneratorMock(int $callCount): GUIDGeneratorInterface
    {
        $map = [(string)mt_rand(), (string)mt_rand()];

        $mock = $this->createMock(GUIDGeneratorInterface::class);
        $mock
            ->expects(self::exactly($callCount))
            ->method('v4')
            ->will(self::onConsecutiveCalls(...$map))
        ;
        
        return $mock;
    }
}
