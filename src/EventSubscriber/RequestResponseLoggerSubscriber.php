<?php

namespace App\EventSubscriber;

use Psr\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class RequestResponseLoggerSubscriber.
 *
 * @author Saeed Jazei <cs.jazei@gmail.com>
 */
class RequestResponseLoggerSubscriber implements EventSubscriberInterface
{

    private LoggerInterface $logger;

    private ContainerInterface $container;

    private ValidatorInterface $validator;

    /**
     * RequestResponseLoggerSubscriber constructor.
     * @param LoggerInterface $requestResponseLogger
     * @param ContainerInterface $container
     * @param ValidatorInterface $validator
     */
    public function __construct(LoggerInterface $requestResponseLogger, ContainerInterface $container, ValidatorInterface $validator)
    {
        $this->logger = $requestResponseLogger;
        $this->container = $container;
        $this->validator = $validator;
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
