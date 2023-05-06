<?php
declare(strict_types=1);

namespace Musheabdulhakim\Paystack\Api;

use Musheabdulhakim\Paystack\Contracts\PaystackClientInterface;

/**
 * The Refunds API allows you create and manage transaction refunds.
 * @link https://paystack.com/docs/api/refund#refunds
 */
class Refund
{
    private $client;

    public function __construct(PaystackClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * Initiate a refund on your integration
     *
     * @param string $transaction Transaction reference or id
     * @param array $params Optional parameters. Refer to the docs
     * @return array
     * @link https://paystack.com/docs/api/refund#create
     */
    public function create(string $transaction, $params = []): array
    {
        $params['transaction'] = $transaction;
        return $this->client->post("refund", $params);
    }

    /**
     * List refunds available on your integration.
     *
     * @param array $params Query parameters. Refer to the docs
     * @return array
     * @link https://paystack.com/docs/api/refund#list
     */
    public function list($params = []): array
    {
        return $this->client->get("refund", $params);
    }

    /**
     * Get details of a refund on your integration.
     *
     * @param string $reference Identifier for transaction to be refunded
     * @return array
     * @link https://paystack.com/docs/api/refund#fetch
     */
    public function fetch(string $reference): array
    {
        return $this->client->get("refund/{$reference}");
    }
}
