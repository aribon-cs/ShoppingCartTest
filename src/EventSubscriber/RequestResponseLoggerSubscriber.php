<?php

namespace App\EventSubscriber;

use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\Event\ResponseEvent;

/**
 * Class RequestResponseLoggerSubscriber.
 *
 * @author Saeed Jazei <cs.jazei@gmail.com>
 */
class RequestResponseLoggerSubscriber implements EventSubscriberInterface
{

    private LoggerInterface $logger;

    /**
     * RequestResponseLoggerSubscriber constructor.
     * @param LoggerInterface $requestResponseLogger
     */
    public function __construct(LoggerInterface $requestResponseLogger)
    {
        $this->logger = $requestResponseLogger;
    }

    public function onRequest(RequestEvent $event): void
    {
        $request = $event->getRequest();

        $this->logger->info('###############################################################################');
        $this->logger->info('###############################################################################');
        $this->logger->info('request uri', [$request->getUri()]);
        $this->logger->info('request body', [$request->getContent()]);
        $this->logger->info('request ContentType', [$request->getContentType()]);
        $this->logger->info('request QueryString', [$request->getQueryString()]);
        $this->logger->info('===============================================================================');
    }

    public function onResponse(ResponseEvent $event): void
    {
        $response = $event->getResponse();

        $this->logger->info('===============================================================================');
        $this->logger->info('response body', [$response->getContent()]);
        $this->logger->info('response Date', [$response->getDate()]);
        $this->logger->info('response StatusCode', [$response->getStatusCode()]);
        $this->logger->info('###############################################################################');
        $this->logger->info('###############################################################################');
    }

    public static function getSubscribedEvents(): array
    {
        return [
//            'kernel.request' => ['onRequest', 256],
//            'kernel.response' => ['onResponse', 256],
        ];
    }
}
