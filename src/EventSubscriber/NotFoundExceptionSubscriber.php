<?php

namespace App\EventSubscriber;

use App\Exceptions\NotFoundException;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\KernelEvents;

/**
 * Class NotFoundExceptionSubscriber.
 *
 * @author Saeed Jazei <cs.jazei@gmail.com>
 */
class NotFoundExceptionSubscriber implements EventSubscriberInterface
{
    private bool $isDev;

    /**
     * ApiExceptionSubscriber constructor.
     */
    public function __construct(ParameterBagInterface $parameterBag)
    {
        $this->isDev = 'dev' == $parameterBag->get('app.environment');
    }

    final public function onKernelException(ExceptionEvent $event): void
    {
        $e = $event->getThrowable();
        $message = $e->getMessage();
        if (!$e instanceof NotFoundHttpException) {
            return;
        }
        if (!$this->isDev) {
            $message = 'Not found!';
        }

        throw new NotFoundException($message);
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::EXCEPTION => 'onKernelException',
        ];
    }
}
