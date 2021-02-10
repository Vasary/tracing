<?php

namespace Vasary\XTraceId\Infrastructure\LoggerProcessor;

use Vasary\XTraceId\Domain\LoggerProcessor\LoggerProcessorInterface;

final class EnvironmentProcessor implements LoggerProcessorInterface
{
    public const FIELD_NAME = 'environment';

    private $environment;

    public function __construct(string $environment)
    {
        $this->environment = $environment;
    }

    public function __invoke(array $record): array
    {
        $record['extra'][self::FIELD_NAME] = $this->environment;

        return $record;
    }
}
