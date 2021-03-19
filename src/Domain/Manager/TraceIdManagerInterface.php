<?php

declare(strict_types=1);

namespace Vasary\XTraceId\Domain\Manager;

use Vasary\XTraceId\Domain\ValueObject\TraceId;

interface TraceIdManagerInterface
{
    public function create(string $id);

    public function get(): TraceId;
}
