<?php

namespace App\EventSubscriber;

use App\Exceptions\ApiBaseException;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;

/**
 * Class ApiExceptionSubscriber.
 *
 * @author Saeed Jazei <cs.jazei@gmail.com>
 */
class ApiExceptionSubscriber implements EventSubscriberInterface
{
    final public function onKernelException(ExceptionEvent $event): void
    {
        $e = $event->getThrowable();
        if (!$e instanceof ApiBaseException) {
            return;
        }

        $apiProblem = $e->getApiException();
        $response = new JsonResponse(
            $apiProblem->toArray(),
            $apiProblem->getStatusCode()
        );

        $response->headers->set('Content-Type', 'application/problem+json');
        $event->setResponse($response);
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::EXCEPTION => 'onKernelException',
        ];
    }
}
