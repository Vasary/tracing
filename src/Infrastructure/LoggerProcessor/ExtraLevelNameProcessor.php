<?php

namespace Vasary\XTraceId\Infrastructure\LoggerProcessor;

use Vasary\XTraceId\Domain\LoggerProcessor\LoggerProcessorInterface;

final class ExtraLevelNameProcessor implements LoggerProcessorInterface
{
    public function __invoke(array $record): array
    {
        if (!isset($record['level_name'])) {
            return $record;
        }

        $record['extra']['level_name'] = $record['level_name'];

        return $record;
    }
}
