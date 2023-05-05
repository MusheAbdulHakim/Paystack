<?php

declare(strict_types=1);

namespace Musheabdulhakim\Paystack\Api;

use Musheabdulhakim\Paystack\Contracts\PaystackClientInterface;

/**
 * The Subaccounts API allows you create and manage subaccounts on your integration. Subaccounts can be used to split payment between two accounts (your main account and a sub account).
 * @link https://paystack.com/docs/api/subaccount#subaccounts
 */
class SubAccount
{
    private $client;

    public function __construct(PaystackClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * Create a subacount on your integration
     *
     * @param string $business_name Name of business for subaccount
     * @param string $settlement_bank Bank Code for the bank. You can get the list of Bank Codes by calling the List Banks endpoint @link https://paystack.com/docs/api/miscellaneous#bank.
     * @param string $account_number Bank Account Number
     * @param float $percentage_charge The default percentage charged when receiving on behalf of this subaccount
     * @param string $description A description for this subaccount
     * @param array $params Optional parameters. Refer to the docs
     * @return array
     * @link https://paystack.com/docs/api/subaccount#create
     */
    public function create(string $business_name, string $settlement_bank, string $account_number, float $percentage_charge, string $description, $params = []): array
    {
        $params['business_name'] = $business_name;
        $params['settlement_bank'] = $settlement_bank;
        $params['account_number'] = $account_number;
        $params['percentage_charge'] = $percentage_charge;
        $params['description'] = $description;
        return $this->client->post('subaccount', $params);
    }

    /**
     * List subaccounts available on your integration.
     *
     * @param integer $perPage Specify how many records you want to retrieve per page. If not specify we use a default value of 50.
     * @param integer $page Specify exactly what page you want to retrieve. If not specify we use a default value of 1.
     * @param array $params Optional parameters. Refer to the docs
     * @return array
     * @link https://paystack.com/docs/api/subaccount#list
     */
    public function list(int $perPage, int $page, $params = []): array
    {
        $params['perPage'] = $perPage;
        $params['page'] = $page;
        return $this->client->get('subaccount', $params);
    }

    /**
     * Get details of a subaccount on your integration.
     *
     * @param string $id_or_code The subaccount ID or code you want to fetch
     * @return array
     * @link https://paystack.com/docs/api/subaccount#fetch
     */
    public function fetch(string $id_or_code): array
    {
        return $this->client->get("subaccount/{$id_or_code}");
    }

    /**
     * Update a subaccount details on your integration
     *
     * @param string $id_or_code Subaccount's ID or code
     * @param string $business_name Subaccount's ID or code
     * @param string $settlement_bank Bank Code for the bank. You can get the list of Bank Codes by calling the List Banks endpoint @link https://paystack.com/docs/api/miscellaneous#bank.
     * @param [type] $params
     * @return array
     */
    public function update(string $id_or_code, string $business_name, string $settlement_bank, $params): array
    {
        $params['business_name'] = $business_name;
        $params['settlement_bank'] = $settlement_bank;
        return $this->client->put("subaccount/{$id_or_code}", $params);
    }
}
