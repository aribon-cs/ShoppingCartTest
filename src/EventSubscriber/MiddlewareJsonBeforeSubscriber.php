<?php

namespace App\EventSubscriber;

use App\Exceptions\CustomBadException;
use Psr\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class MiddlewareJsonBeforeSubscriber.
 *
 * @author Saeed Jazei <cs.jazei@gmail.com>
 */
class MiddlewareJsonBeforeSubscriber implements EventSubscriberInterface
{
    private LoggerInterface $logger;
    private ContainerInterface $container;
    private ValidatorInterface $validator;

    /**
     * MiddlewareJsonBeforeSubscriber constructor.
     */
    public function __construct(LoggerInterface $logger, ContainerInterface $container, ValidatorInterface $validator)
    {
        $this->logger = $logger;
        $this->container = $container;
        $this->validator = $validator;
    }

    public function onKernelRequest(RequestEvent $event): void
    {
        $request = $event->getRequest();
        $event->getRequest()->getContentType();
        $content = $request->getContent();

        // pass this middleware if not be a json request
        // hint:  if you want to restrict all request be a json remove this condition
        if (false === strpos($request->getContentType(), 'json')) {
            return;
        }

        $this->logger->info('middlewareJson:onKernelRequest: content gotten in Request', [$content]);
        $json = json_decode($content);
        if (JSON_ERROR_NONE !== json_last_error()) {
            throw new CustomBadException(json_last_error_msg());
        }
        $request->attributes->add(['json' => $json]);
    }

    public function onKernelController(ControllerEvent $event): void
    {
        $request = $event->getRequest();
        $content = $request->getContent();

        // pass this middleware if not be a json request
        // hint:  if you want to restrict all request be a json remove this condition
        if (false === strpos($request->getContentType(), 'json')) {
            return;
        }

        $this->logger->info('middlewareJson:onKernelController: content gotten in Controller', [$content]);
        $json = json_decode($content, true);
        if (is_null($json)) {
            $this->logger->info('middlewareJson:onKernelController: json is null', [$json]);
            throw new CustomBadException('bad syntax');
        }
        $this->logger->info('middlewareJson:onKernelController: json is NOT null', [$json]);
    }

    public static function getSubscribedEvents(): array
    {
        return [
//            'kernel.request' => ['onKernelRequest', 100],
//            'kernel.controller' => ['onKernelController', 256],
        ];
    }
}
