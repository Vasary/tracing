<?php

declare(strict_types=1);

namespace Vasary\XTraceId\Tests\Unit\Infrastructure\Generator;

use PHPUnit\Framework\TestCase;
use Vasary\XTraceId\Domain\GUIDGenerator\GUIDGeneratorInterface;
use Vasary\XTraceId\Domain\Manager\TraceIdManagerInterface;
use Vasary\XTraceId\Infrastructure\Manager\TraceIdManager;
use Vasary\XTraceId\Infrastructure\Storage\TraceIdStorage;

final class TraceIdManagerTest extends TestCase
{
    /**
     * @test
     */
    public function instanceOf(): void
    {
        $manager = new TraceIdManager($this->getGeneratorMock(1), new TraceIdStorage());

        self::assertInstanceOf(TraceIdManagerInterface::class, $manager);
    }

    /**
     * @test
     */
    public function exists(): void
    {
        $manager = new TraceIdManager($this->getGeneratorMock(1), new TraceIdStorage());

        self::assertNotEmpty($manager->get());
    }

    /**
     * @test
     */
    public function set(): void
    {
        $manager = new TraceIdManager($this->getGeneratorMock(1), new TraceIdStorage());

        $manager->create('my_trace');

        self::assertEquals('my_trace', $manager->get());
    }

    /**
     * @test
     */
    public function reset(): void
    {
        $manager = new TraceIdManager($this->getGeneratorMock(2), new TraceIdStorage());

        $initiatedTraceId = $manager->get();
        $manager->reset();
        $afterResetTraceId = $manager->get();

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
