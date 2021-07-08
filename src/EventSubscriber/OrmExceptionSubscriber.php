<?php

namespace App\EventSubscriber;

use App\Exceptions\OperationFailedException;
use App\Exceptions\TryLaterException;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;

/**
 * Class OrmExceptionSubscriber.
 *
 * @author Saeed Jazei <cs.jazei@gmail.com>
 */
class OrmExceptionSubscriber implements EventSubscriberInterface
{
    final public function onKernelException(ExceptionEvent $event): void
    {
        $e = $event->getThrowable();

        if ($e instanceof OptimisticLockException) {
            throw new TryLaterException();
        }

        if ($e instanceof ORMException) {
            throw new OperationFailedException();
        }

        if ($e instanceof UniqueConstraintViolationException) {
            throw new OperationFailedException('duplicated!');
        }
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::EXCEPTION => 'onKernelException',
        ];
    }
}
