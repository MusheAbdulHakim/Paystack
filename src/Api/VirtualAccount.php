<?php

declare(strict_types=1);

namespace Musheabdulhakim\Paystack\Api;

use Musheabdulhakim\Paystack\Contracts\PaystackClientInterface;

/**
 * The Dedicated Virtual Account API enables Nigerian merchants to manage unique payment accounts of their customers.
 * @link https://paystack.com/docs/api/dedicated-virtual-account#dedicated-virtual-accounts
 */
class VirtualAccount
{
    private $client;

    public function __construct(PaystackClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * Create a dedicated virtual account for an existing customer
     *
     * @param string $customer Customer ID or code
     * @param array $params Optional parameters.Refer to the api docs
     * @return array
     * @link https://paystack.com/docs/api/dedicated-virtual-account#create
     */
    public function create(string $customer, $params = []): array
    {
        $params['customer']  = $customer;
        return $this->client->post('dedicated_account', $params);
    }

    /**
     * With this method, you can create a customer, validate the customer, and assign a DVA to the customer.
     *
     * @param string $email Customer email address
     * @param string $first_name Customer's first name
     * @param string $last_name Customer's last name
     * @param string $phone Customer's phone number
     * @param string $preferred_bank The bank slug for preferred bank. To get a list of available banks, use the List Banks endpoint (https://paystack.com/docs/api/miscellaneous#bank), passing pay_with_bank_transfer=true query parameter
     * @param string $country Currently accepts NG only
     * @param array $params Optional parameters. Refer to the api docs
     * @return array
     * @link https://paystack.com/docs/api/dedicated-virtual-account#assign
     */
    public function assign(string $email, string $first_name, string $last_name, string $phone, string $preferred_bank, string $country, $params = []): array
    {
        $params['email'] = $email;
        $params['first_name'] = $first_name;
        $params['last_name'] = $last_name;
        $params['phone'] = $phone;
        $params['preferred_bank'] = $preferred_bank;
        $params['country'] = $country;
        return $this->client->post('dedicated_account/assign', $params);
    }

    /**
     * List dedicated virtual accounts available on your integration.
     *
     * @param string $active Status of the dedicated virtual account
     * @param string $currency The currency of the dedicated virtual account. Only NGN is currently allowed
     * @param array $params Optional parameters.Refer to the api docs
     * @return array
     * @link https://paystack.com/docs/api/dedicated-virtual-account#list
     */
    public function list(string $active, string $currency, $params = []): array
    {
        $params['active'] = $active;
        $params['currency'] = $currency;
        return $this->client->get('dedicated_account', $params);
    }

    /**
     * Get details of a dedicated virtual account on your integration.
     *
     * @param integer $dedicated_account_id ID of dedicated virtual account
     * @return array
     * @link https://paystack.com/docs/api/dedicated-virtual-account#fetch
     */
    public function fetch(int $dedicated_account_id): array
    {
        return $this->client->get("dedicated_account/{$dedicated_account_id}");
    }

    /**
     * Requery Dedicated Virtual Account for new transactions
     *
     * @param string $account_number Virtual account number to requery
     * @param string $provider_slug The bank's slug in lowercase, without spaces e.g. wema-bank
     * @param string|null $date The day the transfer was made in YYYY-MM-DD format
     * @return array
     * @link https://paystack.com/docs/api/dedicated-virtual-account#requery
     */
    public function reQuery(string $account_number, string $provider_slug, string $date = null): array
    {
        $params['account_number'] = $account_number;
        $params['provider_slug'] = $provider_slug;
        $params['date'] = $date;
        return $this->client->get('dedicated_account/requery', $params);
    }

    /**
     * Deactivate a dedicated virtual account on your integration.
     *
     * @param integer $dedicated_account_id Deactivate a dedicated virtual account on your integration.
     * @return array
     * @link https://paystack.com/docs/api/dedicated-virtual-account#deactivate
     */
    public function deActivate(int $dedicated_account_id): array
    {
        return $this->client->delete("dedicated_account/{$dedicated_account_id}");
    }

    /**
     * Split a dedicated virtual account transaction with one or more accounts
     *
     * @param string $customer Customer ID or code
     * @param array $params Optional parameters. Refer to the docs
     * @return array
     * @link https://paystack.com/docs/api/dedicated-virtual-account#add-split
     */
    public function split(string $customer, $params = []): array
    {
        $params['customer'] = $customer;
        return $this->client->post('dedicated_account/split', $params);
    }

    /**
     * If you've previously set up split payment for transactions on a dedicated virtual account, you can remove it with this endpoint
     *
     * @param string $account_number Dedicated virtual account number
     * @return array
     * @link https://paystack.com/docs/api/dedicated-virtual-account#remove-split
     */
    public function removeSplit(string $account_number): array
    {
        $params['account_number'] = $account_number;
        return $this->client->delete('dedicated_account/split', $params);
    }

    /**
     * Get available bank providers for a dedicated virtual account
     *
     * @return array
     * @link https://paystack.com/docs/api/dedicated-virtual-account#providers
     */
    public function fetchBankProviders(): array
    {
        return $this->client->get('dedicated_account/available_providers');
    }

    /**
     * Get available bank providers for a dedicated virtual account
     *
     * @return array
     * @link https://paystack.com/docs/api/dedicated-virtual-account#providers
     */
    public function bankProviders(): array
    {
        return $this->fetchBankProviders();
    }

}
