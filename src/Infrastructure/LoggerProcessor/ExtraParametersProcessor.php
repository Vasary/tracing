<?php

namespace Vasary\XTraceId\Infrastructure\LoggerProcessor;

use Vasary\XTraceId\Domain\LoggerProcessor\LoggerProcessorInterface;

final class ExtraParametersProcessor implements LoggerProcessorInterface
{
    public const FIELD_NAME = 'extra';

    private array $extraParameters;

    public function __construct(array $extraParameters = [])
    {
        $this->extraParameters = $extraParameters;
    }

    public function __invoke(array $record): array
    {
        if (empty($this->extraParameters)) {
            return $record;
        }

        foreach ($this->extraParameters as $key => $value) {
            $record[self::FIELD_NAME][$key] = $value;
        }

        return $record;
    }
}
