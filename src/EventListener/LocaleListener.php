<?php

declare(strict_types=1);

namespace App\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class LocaleListener implements EventSubscriberInterface
{
    public function onRequest(GetResponseEvent $e)
    {
        $locale = $e->getRequest()->getPreferredLanguage(['en', 'de', 'es']);

        $e->getRequest()->setLocale($locale);
        $e->getRequest()->getSession()->set('locale', $locale);
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::REQUEST => 'onRequest'
        ];
    }
}
