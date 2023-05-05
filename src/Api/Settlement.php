<?php

declare(strict_types=1);

namespace Musheabdulhakim\Paystack\Api;

use Musheabdulhakim\Paystack\Contracts\PaystackClientInterface;

/**
 * The Settlements API allows you gain insights into payouts made by Paystack to your bank account.
  *  @link https://paystack.com/docs/api/settlement#settlements
 */
class Settlement
{
    private $client;

    public function __construct(PaystackClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * List settlements made to your settlement accounts.
     *
     * @param array $params Query parameters. Refer to the docs
     * @return array
     * @link https://paystack.com/docs/api/settlement#list
     */
    public function list($params = []): array
    {
        return $this->client->get("settlement", $params);
    }

    /**
     * Get the transactions that make up a particular settlement
     * Note: If you plan to store or make use of the the transaction ID, you should represent it as a unsigned 64-bit integer. To learn more, check out our changelog @link https://paystack.com/docs/changelog/api/#june-2022.
     *
     * @param string $id The settlement ID in which you want to fetch its transactions
     * @param array $params Query parameters.
     * @return array
     */
    public function transactions(string $id, $params = []): array
    {
        return $this->client->get("settlement/{$id}/transactions", $params);
    }
}
