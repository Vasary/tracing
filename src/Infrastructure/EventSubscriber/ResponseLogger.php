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

        if ($id = $this->manager->get()) {
            $event->getResponse()->headers->set($this->headerName, $id);
        }

        $headers = $event->getResponse()->headers->all();
        if (0 === mb_strlen($event->getResponse()->getContent())) {
            $this->logger->info('Outgoing response body is empty', $headers);
        } else {
            $this->logger->info('Outgoing response: ' . $event->getResponse()->getContent(), $headers);
        }
    }
}
