<?php

declare(strict_types=1);

namespace Vasary\XTraceId\Infrastructure\EventSubscriber;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Vasary\XTraceId\Domain\EventSubscriber\RequestLoggerInterface;

final class RequestLogger extends AbstractLogger implements RequestLoggerInterface
{
    public static function getSubscribedEvents() : array
    {
        return [
            KernelEvents::REQUEST => ['onKernelRequest', 100]
        ];
    }

    public function onKernelRequest(RequestEvent $event): void
    {
        if (!$event->isMasterRequest()) {
            return;
        }

        $request = $event->getRequest();

        $this->initialize($request);

        $this->logger->info(sprintf('Entrypoint: [%s] %s', $request->getMethod(), $request->getPathInfo()));
        $this->logger->info('Request: ' . $request->getContent());
    }

    private function initialize(Request $request): void
    {
        if ($id = $request->headers->get($this->headerName)) {
            $this->generator->set($id);
            return;
        }

        $request->headers->set($this->headerName, $this->generator->get());
    }
}
