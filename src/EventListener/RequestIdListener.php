<?php

declare(strict_types=1);

namespace App\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class RequestIdListener implements EventSubscriberInterface
{
    public function onRequest(GetResponseEvent $e)
    {
        $id = md5(random_bytes(64));

        $e->getRequest()->attributes->set('app_id', $id);
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::REQUEST => 'onRequest'
        ];
    }
}
