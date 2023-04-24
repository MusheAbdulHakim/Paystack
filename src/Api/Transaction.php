<?php

declare(strict_types=1);

namespace Musheabdulhakim\Paystack\Api;

use Musheabdulhakim\Paystack\Contracts\PaystackClientInterface;

/**
 * The Transactions API allows you create and manage payments on your integration
 * @link https://paystack.com/docs/api/#transaction
 */
class Transaction
{
    private $client;

    public function __construct(PaystackClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * Initialize a transaction from your backend
     *
     * @param string $email
     * @param string $amount
     * @param array $params
     * @return mixed
     */
    public function init(string $email, string $amount, $params = []): mixed
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
     * @return mixed
     */
    public function list($params = []): mixed
    {
        return $this->client->get('transaction', $params);
    }

    /**
     * Verify Transaction
     *
     * @link https://paystack.com/docs/api/#transaction-verify
     * @param string $reference
     * @return mixed
     */
    public function verify(string $reference): mixed
    {
        $params['reference'] = $reference;
        return $this->client->get('transaction/verify/'.$reference);
    }

    /**
     * Get details of a transaction carried out on your integration.
     *
     * @link https://paystack.com/docs/api/#transaction-fetch
     * @param integer $id .An ID for the transaction to fetch
     * @return mixed
     */
    public function get(int $id): mixed
    {
        return $this->client->get('transaction/'.$id);
    }


    /**
     * Get details of a transaction carried out on your integration.
     *
     * @link https://paystack.com/docs/api/#transaction-fetch
     * @param integer $id .An ID for the transaction to fetch
     * @return mixed
     */
    public function fetch(int $id): mixed
    {
        return $this->client->get('transaction/'.$id);
    }

    /**
     * All authorizations marked as reusable can be charged with this endpoint whenever you need to receive payments.
     *
     * @link https://paystack.com/docs/api/#transaction-charge-authorization
     * @param string $email
     * @param string $amount
     * @param string $authorization_code
     * @param array $params
     * @return mixed
     */
    public function chargeAuth(string $email, string $amount, string $authorization_code, $params = []): mixed
    {
        $params['email'] = $email;
        $params['amount'] = $amount;
        $params['authorization_code'] = $authorization_code;

        return $this->client->post('transaction/charge_authorization', $params);
    }


    /**
     * All Mastercard and Visa authorizations can be checked with this endpoint to know if they have funds for the payment you seek.
     *  This endpoint should be used when you do not know the exact amount to charge a card when rendering a service.
     *  It should be used to check if a card has enough funds based on a maximum range value.
     *  It is well suited for:
     *   - Ride hailing services
     *   - Logistics services
     *
     *  **Warning**
     *   You shouldn't use this endpoint to check a card for sufficient funds if you are going to charge the user immediately. This is because we hold funds when this endpoint is called which can lead to an insufficient funds error.
     *
     * @link https://paystack.com/docs/api/#transaction-check-authorization
     * @param string $email
     * @param string $amount
     * @param string $authorization_code
     * @param array $params
     * @return mixed
     */
    public function checkAuth(string $email, string $amount, string $authorization_code, $params = []): mixed
    {
        $params['email'] = $email;
        $params['amount'] = $amount;
        $params['authorization_code'] = $authorization_code;

        return $this->client->post('transaction/check_authorization', $params);
    }


    /**
     * View the timeline of a transaction
     *
     * @link https://paystack.com/docs/api/#transaction-view-timeline
     * @param string $id_or_reference .The ID or the reference of the transaction
     * @return mixed
     */
    public function timeline(string $id_or_reference): mixed
    {
        return $this->client->get('transaction/timeline/'.$id_or_reference);
    }

    /**
     * Total amount received on your account
     *
     * @link https://paystack.com/docs/api/#transaction-totals
     * @param array $params
     * @return mixed
     */
    public function total($params = []): mixed
    {
        return $this->client->get('transaction/totals');
    }

    /**
     * List transactions carried out on your integration.
     *
     * @link https://paystack.com/docs/api/#transaction-export
     * @param array $params
     * @return mixed
     */
    public function export($params = []): mixed
    {
        return $this->client->get('transaction/export');
    }


     /**
      * Retrieve part of a payment from a customer
      *
      * @param string $authorization_code Authorization Code
      * @param string $currency Specify the currency you want to debit. Allowed values are NGN, GHS, ZAR or USD.
      * @param string $amount Amount should be in kobo if currency is NGN, pesewas, if currency is GHS, and cents, if currency is ZAR
      * @param string $email Customer's email address (attached to the authorization code)
      * @param array $params
      * @link https://paystack.com/docs/api/#transaction-partial-debit
      * @return mixed
      */
    public function partialDebit(string $authorization_code, string $currency, string $amount, string $email, $params = []): mixed
    {
        $params['authorization_code'] = $authorization_code;
        $params['currency'] = $currency;
        $params['amount'] = $amount;
        $params['email'] = $email;
        return $this->client->post('transaction/partial_debit', $params);
    }
}
