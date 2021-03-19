<?php

declare(strict_types=1);

namespace Vasary\XTraceId\Domain\Storage;

use Vasary\XTraceId\Domain\ValueObject\TraceId;

interface TraceIdStorageInterface
{
    public function save(TraceId $id);

    public function get(): TraceId;
}
