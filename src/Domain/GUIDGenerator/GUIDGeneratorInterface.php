<?php

declare(strict_types=1);

namespace Vasary\XTraceId\Domain\GUIDGenerator;

interface GUIDGeneratorInterface
{
    public function v4(): string;
}
