<?php

declare(strict_types=1);

namespace Vasary\XTraceId\Infrastructure\EventSubscriber;

use Psr\Log\LoggerInterface;
use Vasary\XTraceId\Domain\Generator\TraceIdGeneratorInterface;

abstract class AbstractLogger
{
    protected $generator;

    protected $logger;

    protected $headerName;

    public function __construct(TraceIdGeneratorInterface $generator, LoggerInterface $logger, string $headerName)
    {
        $this->generator = $generator;
        $this->logger = $logger;
        $this->headerName = $headerName;
    }
}
