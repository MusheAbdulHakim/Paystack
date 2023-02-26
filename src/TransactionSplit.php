<?php

declare(strict_types=1);

namespace Musheabdulhakim\Paystack;

use Musheabdulhakim\Paystack\Client;
use GuzzleHttp\Psr7;

/**
 * The Transaction Splits API enables merchants split the settlement for a transaction across their payout account, and one or more Subaccounts.
 * @link https://paystack.com/docs/api/#split
 */
class TransactionSplit
{
    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Create a split payment on your integration
     *
     * @param string $name
     * @param string $type
     * @param string $currency
     * @param array $subaccounts
     * @param string $bearer_type
     * @param string $bearer_subaccount
     * @return mixed
     */
    public function create(string $name, string $type, string $currency, $subaccounts = [], string $bearer_type, string $bearer_subaccount): mixed
    {
        $params['name'] = $name;
        $params['type'] = $type;
        $params['currency'] = $currency;
        $params['subaccounts'] = $subaccounts;
        $params['bearer_type'] = $bearer_type;
        $params['bearer_subaccount'] = $bearer_subaccount;
        return $this->client->post('split');
    }
}
