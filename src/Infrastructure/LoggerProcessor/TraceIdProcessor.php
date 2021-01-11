<?php

namespace Vasary\XTraceId\Infrastructure\LoggerProcessor;

use Vasary\XTraceId\Domain\Generator\TraceIdGeneratorInterface;
use Vasary\XTraceId\Domain\LoggerProcessor\LoggerProcessorInterface;

final class TraceIdProcessor implements LoggerProcessorInterface
{
    private TraceIdGeneratorInterface $generator;

    private string $fieldName;

    public function __construct(TraceIdGeneratorInterface $generator, string $fieldName)
    {
        $this->generator = $generator;
        $this->fieldName = $fieldName;
    }

    public function __invoke(array $record): array
    {
        $record['extra'][$this->fieldName] = $this->generator->get();

        return $record;
    }
}
