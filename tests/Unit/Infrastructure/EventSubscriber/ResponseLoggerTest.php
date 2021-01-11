<?php

declare(strict_types=1);

namespace Vasary\XTraceId\Tests\Unit\Infrastructure\EventSubscriber;

use PHPUnit\Framework\TestCase;
use Psr\Log\NullLogger;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Vasary\XTraceId\Domain\Generator\TraceIdGeneratorInterface;
use Vasary\XTraceId\Infrastructure\EventSubscriber\ResponseLogger;

final class ResponseLoggerTest extends TestCase
{
    private const HEADER = 'X-Trace-ID';
    private const DEFAULT_TRACE = 'test_trace';

    /**
     * @test
     */
    public function subscriberParameters(): void
    {
        $events = ResponseLogger::getSubscribedEvents();

        self::assertIsArray($events);
        self::assertArrayHasKey('kernel.response', $events);
        self::assertLessThan(0, $events['kernel.response'][1]);
    }

    /**
     * @test
     */
    public function success(): void
    {
        $responseSubscriber =
            new ResponseLogger($this->getTraceIdGeneratorMock(1), new NullLogger(), self::HEADER)
        ;

        $responseEvent = $this->getResponseEvent(HttpKernelInterface::MASTER_REQUEST);
        $responseSubscriber->onKernelResponse($responseEvent);

        self::assertArrayHasKey(mb_strtolower(self::HEADER), $responseEvent->getResponse()->headers->all());
        self::assertEquals(self::DEFAULT_TRACE, $responseEvent->getResponse()->headers->get(self::HEADER));
    }

    /**
     * @test
     */
    public function empty(): void
    {
        $responseSubscriber =
            new ResponseLogger($this->getTraceIdGeneratorMock(0), new NullLogger(), self::HEADER)
        ;

        $responseEvent = $this->getResponseEvent(HttpKernelInterface::SUB_REQUEST);
        $responseSubscriber->onKernelResponse($responseEvent);

        self::assertArrayNotHasKey(mb_strtolower(self::HEADER), $responseEvent->getResponse()->headers->all());
    }

    private function getResponseEvent(int $requestType): ResponseEvent
    {
        $kernel = $this->createMock(HttpKernelInterface::class);
        $request = $this->createMock(Request::class);

        return new ResponseEvent($kernel, $request, $requestType, new Response());
    }

    private function getTraceIdGeneratorMock(int $callCount): TraceIdGeneratorInterface
    {
        $mock = $this->createMock(TraceIdGeneratorInterface::class);
        $mock
            ->expects(self::exactly($callCount))
            ->method('get')
            ->willReturn(self::DEFAULT_TRACE)
        ;

        return $mock;
    }
}
