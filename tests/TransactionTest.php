<?php

namespace MoneyTrackerPhpClient\Tests;

use MoneyTrackerPhpClient\Transaction;

class TransactionTest extends TestCase
{

    public function createTransaction($attributes = array())
    {
        $faker = \Faker\Factory::create();

        return [
            'id' => isset($attributes['id']) ? $attributes['id'] : $faker->unique()->randomNumber,
            'description' => isset($attributes['description']) ? $attributes['description'] : implode(' ', $faker->words),
            'debit' => isset($attributes['debit']) ? $attributes['debit'] : number_format($faker->randomFloat, 2, '.', ''),
            'credit' =>isset($attributes['credit']) ? $attributes['credit'] : number_format($faker->randomFloat, 2, '.', ''),
        ];
    }

    public function createApi($body, $code = 200)
    {
        return new Transaction($this->mockGuzzle($this->createResponse($body, $code)));
    }

    public function testAll()
    {
        $api = $this->createApi([
            $this->createTransaction(),
            $this->createTransaction()
        ]);

        $this->assertEquals(2, count($api->all()));
    }

    public function testCreate()
    {
        $transaction = $this->createTransaction();

        $api = $this->createApi($transaction, 201);

        $this->assertJsonEquals($transaction, $api->create($transaction));
    }
    
    public function testFind()
    {
        $transaction = $this->createTransaction(['id' => 1]);

        $api = $this->createApi($transaction);

        $this->assertJsonEquals($transaction, $api->find(1));
    }

    /**
     * @expectedException OutOfBoundsException
     */
    public function testFindWhenReturns404()
    {
        $api = $this->createApi('', 404);
        $api->find(1);
    }

}
