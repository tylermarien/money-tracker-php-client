<?php

namespace MoneyTrackerPhpClient;

use GuzzleHttp\Client as Guzzle;

class Client
{
    const URL = 'http://money-tracker-api.app';

    private $http;

    public function __construct()
    {
        $this->http = new Guzzle([
            'base_uri' => self::URL,
            'timeout'  => 2.0,
            'headers' => ['Accept' => 'application/json']
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
