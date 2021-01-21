<?php

namespace Vasary\XTraceId\Infrastructure\LoggerProcessor;

use Vasary\XTraceId\Domain\LoggerProcessor\LoggerProcessorInterface;

final class ApplicationNameProcessor implements LoggerProcessorInterface
{
    private $applicationName;

    public function __construct(string $applicationName)
    {
        $this->applicationName = $applicationName;
    }

    public function __invoke(array $record): array
    {
        $record['extra']['application'] = $this->applicationName;

        return $record;
    }
}
