<?php

declare(strict_types=1);

namespace Vasary\XTraceId\Infrastructure\Storage;

use Vasary\XTraceId\Domain\Storage\TraceIdStorageInterface;
use Vasary\XTraceId\Domain\ValueObject\TraceId;
use Webmozart\Assert\Assert;

final class TraceIdStorage implements TraceIdStorageInterface
{
    private $object;

    public function save(TraceId $id)
    {
        $this->object = $id;
    }

    public function get(): TraceId
    {
        Assert::notNull($this->object, 'Empty storage');

        return $this->object;
    }
}
