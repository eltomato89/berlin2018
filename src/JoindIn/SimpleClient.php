<?php

declare(strict_types=1);

namespace App\JoindIn;

use App\Entity\Talk;
use GuzzleHttp\Client as GuzzleClient;

class SimpleClient implements Client
{
    const URL_TALKS = 'https://api.joind.in/v2.1/events/%s/talks?resultsperpage=50';

    /**
     * @var int
     */
    private $eventId;

    /**
     * @var GuzzleClient
     */
    private $guzzle;

    /**
     * @param int $eventId
     */
    public function __construct(int $eventId, GuzzleClient $guzzle)
    {
        $this->eventId = $eventId;
        $this->guzzle = $guzzle;
    }

    public function getTalks()
    {
        $url = sprintf(
            static::URL_TALKS,
            $this->eventId
        );

        $response = $this->guzzle->request('GET', $url);

        $apiData = json_decode($response->getBody()->getContents(), true);
        $talks = [];

        foreach ($apiData['talks'] as $talkData) {
            $talks[] = Talk::create(
                $talkData['talk_title'],
                $talkData['speakers'][0]['speaker_name']
            );
        }

        return $talks;
    }
}
