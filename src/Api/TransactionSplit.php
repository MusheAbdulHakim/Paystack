<?php

declare(strict_types=1);

namespace Musheabdulhakim\Paystack\Api;

use Musheabdulhakim\Paystack\Contracts\PaystackClientInterface;

/**
 * The Transaction Splits API enables merchants split the settlement for a transaction across their payout account, and one or more Subaccounts.
 * @link https://paystack.com/docs/api/#split
 */
class TransactionSplit
{
    private $client;

    public function __construct(PaystackClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * Create a split payment on your integration
     *
     * @param string $name Name of the transaction split
     * @param string $type The type of transaction split you want to create. You can use one of the following: percentage | flat
     * @param string $currency The type of transaction split you want to create. You can use one of the following: percentage | flat
     * @param array $subaccounts A list of object containing subaccount code and number of shares: [{subaccount: ‘ACT_xxxxxxxxxx’, share: xxx},{...}]
     * @param string $bearer_type Any of subaccount | account | all-proportional | all
     * @param string $bearer_subaccount Subaccount code
     * @link https://paystack.com/docs/api/split#create
     * @return array
     */
    public function create(string $name, string $type, string $currency, string $bearer_type, string $bearer_subaccount, $subaccounts = []): array
    {
        $params['name'] = $name;
        $params['type'] = $type;
        $params['currency'] = $currency;
        $params['subaccounts'] = $subaccounts;
        $params['bearer_type'] = $bearer_type;
        $params['bearer_subaccount'] = $bearer_subaccount;
        return $this->client->post('split', $params);
    }


    /**
     * List the transaction splits available on your integration
     *
     * @param array|null $params Query Parameters
     * @return array
     *
     * @link https://paystack.com/docs/api/split#list
     */
    public function list(?array $params = []): array
    {
        return $this->client->get('split', $params);
    }

    /**
     * Get details of a split on your integration.
     *
     * @param string $id Split Id
     * @return array
     *
     * @link https://paystack.com/docs/api/split#fetch
     */
    public function fetch(string $id): array
    {
        $url = "split/{$id}";
        return $this->client->get($url);
    }


    /**
     * Update a transaction split details on your integration
     *
     * @param string $id Split Id
     * @param array $params
     * @return array
     *
     * @link https://paystack.com/docs/api/split#update
     */
    public function update(string $id, $params = []): array
    {
        $url = "split/{$id}";
        return $this->client->put($url, $params);
    }


    /**
     * Add a Subaccount to a Transaction Split, or update the share of an existing Subaccount in a Transaction Split
     *
     * @param string $id Split Id
     * @param string $subaccount This is the sub account code
     * @param integer $share This is the transaction share for the subaccount
     * @return array
     *
     * @link https://paystack.com/docs/api/split#add-subaccount
     */
    public function add(string $id, string $subaccount, int $share): array
    {
        $url = "split/{$id}/subaccount/add";
        $params['subaccount'] = $subaccount;
        $params['share'] = $share;
        return $this->client->post($url, $params);
    }

    /**
     * Remove a subaccount from a transacton split
     *
     * @param string $id Split Id
     * @param string $subaccount This is the sub account code
     * @return array
     * @url https://paystack.com/docs/api/split#remove-subaccount
     */
    public function remove(string $id, string $subaccount): array
    {
        $url = "split/{$id}/subaccount/remove";
        $params['subaccount'] = $subaccount;
        return $this->client->post($url, $params);
    }
}
