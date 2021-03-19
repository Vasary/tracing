<?php

declare(strict_types=1);

namespace Vasary\XTraceId\Infrastructure\EventSubscriber;

use Psr\Log\LoggerInterface;
use Vasary\XTraceId\Domain\Manager\TraceIdManagerInterface;

abstract class AbstractLogger
{
    protected $manager;
    protected $logger;
    protected $headerName;

    public function __construct(TraceIdManagerInterface $manager, LoggerInterface $logger, string $headerName)
    {
        $this->manager = $manager;
        $this->logger = $logger;
        $this->headerName = $headerName;
    }
}
