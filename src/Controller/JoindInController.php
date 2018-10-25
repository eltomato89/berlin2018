<?php

declare(strict_types=1);

namespace App\Controller;

use App\JoindIn\Client;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @Route(path="/api/joindin")
 */
class JoindInController
{
    /**
     * @Route(name="joindin_list")
     */
    public function list(Client $client, SerializerInterface $serializer)
    {
        return JsonResponse::fromJsonString(
            $serializer->serialize($client->getTalks(), 'json')
        );
    }
}
