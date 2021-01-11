<?php

declare(strict_types=1);

namespace Vasary\XTraceId\Domain\Generator;

interface TraceIdGeneratorInterface
{
    public function get(): string;

    public function set(string $traceId): void;

    public function reset(): void;
}
