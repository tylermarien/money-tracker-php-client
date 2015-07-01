<?php

namespace MoneyTrackerPhpClient\Tests;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;

class TestCase extends \PHPUnit_Framework_TestCase
{
    public function createResponse($body, $code = 200)
    {
        return new Response($code, ['Content-Type' => 'application/json'], json_encode($body));
    }

    public function mockGuzzle(Response $response)
    {
        $mock = new MockHandler([$response]);
        $handler = HandlerStack::create($mock);

        return new Client(['handler' => $handler]);
    }

    public function assertJsonEquals($expected, $actual)
    {
        $this->assertEquals(json_encode($expected), json_encode($actual));
    }

}
