<?php

declare(strict_types=1);

namespace Vasary\XTraceId\Domain\ValueObject;

final class TraceId
{
    /** @var string **/
    private $id;

    public function __construct(string $id)
    {
        $this->id = $id;
    }

    public function __toString(): string
    {
        return $this->id;
    }

    public function id(): string
    {
        return $this->id;
    }
}