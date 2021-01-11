<?php

declare(strict_types=1);

namespace Vasary\XTraceId\Domain\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ResponseEvent;

interface ResponseLoggerInterface extends EventSubscriberInterface
{
    public function onKernelResponse(ResponseEvent $event): void;
}
