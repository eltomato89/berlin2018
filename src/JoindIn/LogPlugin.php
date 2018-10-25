<?php

declare(strict_types=1);

namespace App\JoindIn;

use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Psr\Log\LoggerInterface;

class LogPlugin implements Plugin
{
    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function filterRequest(Request $request): Request
    {
        return $request;
    }

    public function filterResponse(Response $response): Response
    {
        $this->logger->debug('received api data', [$response->getBody()->__toString()]);

        return $response;
    }
}
