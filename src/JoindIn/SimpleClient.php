<?php

declare(strict_types=1);

namespace App\JoindIn;

use App\Entity\Talk;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Psr7\Request;

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
     * @var Plugin[]
     */
    private $plugins;

    /**
     * @param int $eventId
     */
    public function __construct(int $eventId, GuzzleClient $guzzle)
    {
        $this->eventId = $eventId;
        $this->guzzle = $guzzle;
        $this->plugins = [];
    }

    public function registerPlugin(Plugin $plugin)
    {
        $this->plugins[] = $plugin;
    }

    public function getTalks()
    {
        $url = sprintf(
            static::URL_TALKS,
            $this->eventId
        );

        $request = new Request('GET', $url);

        // run plugins
        foreach ($this->plugins as $plugin) {
            $request = $plugin->filterRequest($request);
        }

        $response = $this->guzzle->send($request);

        // run plugins
        foreach ($this->plugins as $plugin) {
            $response = $plugin->filterResponse($response);
        }

        $apiData = json_decode($response->getBody()->__toString(), true);
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
