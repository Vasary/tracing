<?php

declare(strict_types=1);

namespace Vasary\XTraceId\Tests\Unit\Infrastructure\EventSubscriber;

use PHPUnit\Framework\TestCase;
use Psr\Log\NullLogger;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Vasary\XTraceId\Domain\GUIDGenerator\GUIDGeneratorInterface;
use Vasary\XTraceId\Domain\Manager\TraceIdManagerInterface;
use Vasary\XTraceId\Infrastructure\EventSubscriber\RequestLogger;
use Vasary\XTraceId\Infrastructure\Manager\TraceIdManager;
use Vasary\XTraceId\Infrastructure\Storage\TraceIdStorage;

final class RequestLoggerTest extends TestCase
{
    private const HEADER = 'X-Trace-ID';
    private const DEFAULT_TRACE = 'test_trace';
    private const INCOMING_TRACE = 'incoming_trace';

    /**
     * @test
     */
    public function subscriberParameters(): void
    {
        $events = RequestLogger::getSubscribedEvents();

        self::assertIsArray($events);
        self::assertArrayHasKey('kernel.request', $events);
        self::assertGreaterThan(0, $events['kernel.request'][1]);
    }

    /**
     * @test
     */
    public function set(): void
    {
        $manager = $this->getTraceIdGeneratorMock(1);
        $subscriber = new RequestLogger($manager, new NullLogger(), self::HEADER);

        $event = $this->getRequestEvent(HttpKernelInterface::MASTER_REQUEST);
        $event->getRequest()->headers->set(self::HEADER, self::INCOMING_TRACE);

        $subscriber->onKernelRequest($event);

        self::assertEquals(self::INCOMING_TRACE, $event->getRequest()->headers->get(self::HEADER));
        self::assertEquals(self::INCOMING_TRACE, $manager->get());
    }

    /**
     * @test
     */
    public function generated(): void
    {
        $manager = $this->getTraceIdGeneratorMock(1);
        $subscriber = new RequestLogger($manager, new NullLogger(), self::HEADER);

        $event = $this->getRequestEvent(HttpKernelInterface::MASTER_REQUEST);

        $subscriber->onKernelRequest($event);

        self::assertEquals(self::DEFAULT_TRACE, $event->getRequest()->headers->get(self::HEADER));
    }

    /**
     * @test
     */
    public function notMasterRequest(): void
    {
        $manager = $this->getTraceIdGeneratorMock(1);
        $subscriber = new RequestLogger($manager, new NullLogger(), self::HEADER);

        $event = $this->getRequestEvent(HttpKernelInterface::SUB_REQUEST);
        $subscriber->onKernelRequest($event);

        self::assertArrayNotHasKey(mb_strtolower(self::HEADER), $event->getRequest()->headers->all());
    }

    private function getRequestEvent(int $requestType): RequestEvent
    {
        $kernel = $this->createMock(HttpKernelInterface::class);

        return new RequestEvent($kernel, new Request(), $requestType);
    }

    private function getTraceIdGeneratorMock(int $callCount): TraceIdManagerInterface
    {
        $mock = $this->createMock(GUIDGeneratorInterface::class);
        $mock
            ->expects(self::exactly($callCount))
            ->method('v4')
            ->willReturn(self::DEFAULT_TRACE)
        ;

        return new TraceIdManager($mock, new TraceIdStorage());
    }
}
