<?php

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;

use MoneyTrackerPhpClient\Transaction;

class TransactionTest extends PHPUnit_Framework_TestCase
{
    private $transaction;

    public function setUp()
    {
        parent::setUp();

        $transactions = [
            [
                'id' => 1,
                'description' => 'Transaction 1',
                'debit' => '12.1221',
                'credit' => '0.0000'
            ],
            [
                'id' => 2,
                'description' => 'Transaction 2',
                'debit' => '12.1221',
                'credit' => '0.0000'
            ]
        ];

        $client = $this->mockGuzzle($this->createResponse($transactions));

        $this->transaction = new Transaction($client);
    }

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

    // public function createTransaction($attributes)
    // {
    //     return [
    //         'id' => $attribute,
    //         'description' => 'Transaction 2',
    //         'debit' => '12.1221',
    //         'credit' => '0.0000'
    //     ]
    // }

    public function testAll()
    {
        $transactions = $this->transaction->all();

        $this->assertEquals(2, count($transactions));
    }

}
