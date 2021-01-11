<?php

declare(strict_types=1);

namespace Vasary\XTraceId\Infrastructure\EventSubscriber;

use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Vasary\XTraceId\Domain\EventSubscriber\ResponseLoggerInterface;

final class ResponseLogger extends AbstractLogger implements ResponseLoggerInterface
{
    public static function getSubscribedEvents() : array
    {
        return [
            KernelEvents::RESPONSE => ['onKernelResponse', -99]
        ];
    }

    public function onKernelResponse(ResponseEvent $event): void
    {
        if (!$event->isMasterRequest()) {
            return;
        }

        if ($id = $this->generator->get()) {
            $event->getResponse()->headers->set($this->headerName, $id);
        }

        $this->logger->info('Outgoing response: ' . $event->getResponse()->getContent());
    }
}
