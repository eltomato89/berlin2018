<?php

declare(strict_types=1);

namespace App\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\GetResponseForControllerResultEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Serializer\SerializerInterface;

class SerializationListener implements EventSubscriberInterface
{
    /**
     * @var SerializerInterface
     */
    private $serializer;

    /**
     * @var string
     */
    private $apiPath;

    /**
     * @param SerializerInterface $serializer
     * @param string $apiPath
     */
    public function __construct(SerializerInterface $serializer, string $apiPath)
    {
        $this->serializer = $serializer;
        $this->apiPath = $apiPath;
    }

    public function onView(GetResponseForControllerResultEvent $e)
    {
        if (0 !== stripos($e->getRequest()->getPathInfo(), $this->apiPath)) {
            return;
        }

        $json = $this->serializer->serialize(
            $e->getControllerResult(),
            'json'
        );

        $e->setResponse(JsonResponse::fromJsonString($json));
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::VIEW => 'onView'
        ];
    }
}
