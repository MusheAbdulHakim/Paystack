<?php

declare(strict_types=1);

namespace Musheabdulhakim\Paystack;

use Musheabdulhakim\Paystack\Client;

class Transaction
{
    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Initialize a transaction from your backend
     *
     * @param string $email
     * @param string $amount
     * @param array $params
     * @return array
     */
    public function init(string $email, string $amount, $params = []): array
    {
        $params['email'] = $email;
        $params['amount'] = $amount;
        return $this->client->post('transaction/initialize', $params);
    }

    /**
     * List transactions carried out on your integration.
     *
     * @link https://paystack.com/docs/api/#transaction-list
     *
     * @param array $params
     * @return array
     */
    public function list($params = []): array
    {
        return $this->client->get('transaction', $params);
    }

    /**
     * Verify Transaction
     *
     * @link https://paystack.com/docs/api/#transaction-verify
     * @param string $reference
     * @return array
     */
    public function verify(string $reference): array
    {
        $params['reference'] = $reference;
        return $this->client->get('transaction/verify/'.$reference);
    }

    /**
     * Get details of a transaction carried out on your integration.
     *
     * @link https://paystack.com/docs/api/#transaction-fetch
     * @param integer $id .An ID for the transaction to fetch
     * @return array
     */
    public function get(int $id): array
    {
        return $this->client->get('transaction/'.$id);
    }
}
