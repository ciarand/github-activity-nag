<?php

namespace Ciarand\GithubActivityNag\Naggers;

// Guzzle components
use Guzzle\Http\Client;
use Guzzle\Http\Exception\ClientErrorResponseException;

class Pushover implements NaggingInterface
{
    protected $config;

    protected $defaultOptions = array(
        'message' => 'Github laziness detected!',
        'priority' => 0,
    );

    protected $possibleOptions = array(
        'token',
        'user',
        'message',
        'device',
        'title',
        'url',
        'url_title',
        'priority',
        'timestamp',
        'sound',
    );


    public function __construct(array $config)
    {
        // Sanitize the input (no malicious headers)
        $this->config = array_intersect_key(
            $config + $this->defaultOptions,
            array_flip($this->possibleOptions)
        );
    }

    public function run($isLazy)
    {
        if ($isLazy) {
            $client = new Client('https://api.pushover.net');
            $endPoint = '/1/messages.json';
            try {
                $client->post(
                    $endPoint,
                    array(),
                    $this->config
                )->send();
            } catch (ClientErrorResponseException $e) {
                // Bummer
            }
        }
    }
}
