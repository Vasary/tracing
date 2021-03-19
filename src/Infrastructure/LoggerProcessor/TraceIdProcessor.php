<?php

namespace Vasary\XTraceId\Infrastructure\LoggerProcessor;

use Vasary\XTraceId\Domain\LoggerProcessor\LoggerProcessorInterface;
use Vasary\XTraceId\Domain\Manager\TraceIdManagerInterface;

final class TraceIdProcessor implements LoggerProcessorInterface
{
    private $manager;
    private $fieldName;

    public function __construct(TraceIdManagerInterface $manager, string $fieldName)
    {
        $this->manager = $manager;
        $this->fieldName = $fieldName;
    }

    public function __invoke(array $record): array
    {
        $record['extra'][$this->fieldName] = $this->manager->get();

        return $record;
    }
}
