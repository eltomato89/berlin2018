<?php

declare(strict_types=1);

namespace App\JoindIn;

use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;

interface Plugin
{
    public function filterRequest(Request $request): Request;

    public function filterResponse(Response $response): Response;
}
