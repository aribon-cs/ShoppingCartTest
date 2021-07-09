<?php

namespace App\EventSubscriber;

use App\Exceptions\ApiBaseException;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Workflow\Exception\NotEnabledTransitionException;
use Symfony\Component\Workflow\Exception\TransitionException;
use Symfony\Component\Workflow\Exception\UndefinedTransitionException;

/**
 * Class NotAllowedTransitionExceptionSubscriber.
 *
 * @author Saeed Jazei <cs.jazei@gmail.com>
 */
class NotAllowedTransitionExceptionSubscriber implements EventSubscriberInterface
{
    private bool $isDev;
    private Security $security;

    /**
     * ApiExceptionSubscriber constructor.
     */
    public function __construct(ParameterBagInterface $parameterBag, Security $security)
    {
        $this->isDev = 'dev' == $parameterBag->get('kernel.environment');
        $this->security = $security;
    }

    final public function onKernelException(ExceptionEvent $event): void
    {
        $e = $event->getThrowable();
        $message = $e->getMessage();

        if (!$this->isDev) {
            $message = 'TransitionException!';
        }

        if (
            $e instanceof NotEnabledTransitionException ||
            $e instanceof TransitionException ||
            $e instanceof UndefinedTransitionException
        ) {
            throw new ApiBaseException(Response::HTTP_NOT_ACCEPTABLE, $message);
        }
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::EXCEPTION => 'onKernelException',
        ];
    }
}
