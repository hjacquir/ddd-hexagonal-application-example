<?php

declare(strict_types=1);

namespace App\Application\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Serializer\SerializerInterface;

class NotFoundExceptionEventSubscriber implements EventSubscriberInterface
{
    private SerializerInterface $serializer;

    /**
     * @param SerializerInterface $serializer
     */
    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::EXCEPTION => ['process', 255],
        ];
    }

    public function process(ExceptionEvent $event)
    {
        $currentException = $event->getThrowable();

        if ($currentException instanceof NotFoundHttpException) {
            $body = $this->serializer->serialize(
                [
                    'code' => Response::HTTP_NOT_FOUND,
                    'message' => 'Sorry but the requested resource does not exist.',
                ],
                'json'
            );

            $event->setResponse(new Response($body, Response::HTTP_NOT_FOUND));
        }
    }
}
