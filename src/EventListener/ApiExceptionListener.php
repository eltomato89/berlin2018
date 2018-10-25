<?php

declare(strict_types=1);

namespace App\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\KernelEvents;

class ApiExceptionListener implements EventSubscriberInterface
{
    /**
     * @var bool
     */
    private $debug;

    /**
     * @var string
     */
    private $apiPath;

    /**
     * @param bool $debug
     */
    public function __construct(bool $debug, string $apiPath)
    {
        $this->debug = $debug;
        $this->apiPath = $apiPath;
    }

    public function onException(GetResponseForExceptionEvent $e)
    {
        return;
        if (0 !== stripos($e->getRequest()->getPathInfo(), $this->apiPath)) {
            return;
        }

        $exception = $e->getException();

        $message = 'Oops';
        $status = Response::HTTP_INTERNAL_SERVER_ERROR;

        if ($this->debug) {
            $message = $exception->getMessage();
        }

        if ($exception instanceof HttpException) {
            $status = $exception->getStatusCode();
        }

        $e->setResponse(
            JsonResponse::create(['message' => $message], $status)
        );
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::EXCEPTION => 'onException'
        ];
    }
}
