<?php

declare(strict_types=1);

namespace Vasary\XTraceId\Domain\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;

interface RequestLoggerInterface extends EventSubscriberInterface
{
    public function onKernelRequest(RequestEvent $event): void;
}
