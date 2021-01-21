<?php

namespace Vasary\XTraceId\Infrastructure\Generator;

use Vasary\XTraceId\Domain\Generator\TraceIdGeneratorInterface;
use Vasary\XTraceId\Domain\GUIDGenerator\GUIDGeneratorInterface;

final class TraceIdGenerator implements TraceIdGeneratorInterface
{
    private $generator;

    private $traceId;

    public function __construct(GUIDGeneratorInterface $generator)
    {
        $this->generator = $generator;
        $this->traceId = $this->generator->v4();
    }

    public function set(string $traceId): void
    {
        $this->traceId = $traceId;
    }

    public function get(): string
    {
        return $this->traceId;
    }

    public function reset(): void
    {
        $this->traceId = $this->generator->v4();
    }
}
