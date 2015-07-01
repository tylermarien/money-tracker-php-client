<?php

namespace MoneyTrackerPhpClient;

use GuzzleHttp\Client as Guzzle;

class Client
{
    const URL = 'http://money-tracker-api.app';
    const TIMEOUT = 2.0;
    const HEADERS = ['Accept' => 'application/json'];

    private $http;

    public function __construct()
    {
        $this->http = new Guzzle([
            'base_uri' => static::URL,
            'timeout'  => static::TIMEOUT,
            'headers' => static::HEADERS
        ]);
    }

    public function api($type)
    {
        switch($type)
        {
            case 'transaction':
                return new Transaction($this->http);
        }

        throw new \Exception('That API does not exist');
    }

}
