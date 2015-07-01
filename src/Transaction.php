<?php

namespace MoneyTrackerPhpClient;

use GuzzleHttp\Client;

class Transaction
{
    private $http;

    public function __construct(Client $http)
    {
        $this->http = $http;
    }

    public function all()
    {
        $response = $this->http->get('transactions');
        if ($response->getStatusCode() !== 200)
        {
            throw new \Exception('Unknown error');
        }

        return json_decode($response->getBody());
    }

    public function create(array $transaction)
    {
        $response = $this->http->post('transactions', ['form_params' => $transaction]);
        if ($response->getStatusCode() !== 201)
        {
            throw new \Exception('Unknown error');
        }

        return json_decode($response->getBody());
    }

    public function find($id)
    {
        try
        {
            $response = $this->http->get('transactions/' . $id);
        }
        catch(\Exception $e)
        {
            switch($e->getCode())
            {
                case 404:
                    throw new \OutOfBoundsException('Transaction does not exist');
                default:
                    throw new \Exception($e->getMessage());
            }
        }

        return json_decode($response->getBody());
    }

    public function update($id, array $transaction)
    {
        $response = $this->http->put('transactions/' . $id, ['form_params' => $transaction]);
        if ($response->getStatusCode() !== 200)
        {
            throw new \Exception('Unknown error');
        }

        return json_decode($response->getBody());
    }

    public function delete($id)
    {
        $response = $this->http->delete('transactions/' . $id);
        if ($response->getStatusCode() !== 204)
        {
            throw new \Exception('Unknown error');
        }
    }

}
