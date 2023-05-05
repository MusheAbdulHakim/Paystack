<?php

declare(strict_types=1);

namespace Musheabdulhakim\Paystack\Api;

use Musheabdulhakim\Paystack\Contracts\PaystackClientInterface;

/**
 * The Payment Requests API allows you manage requests for payment of goods and services.
 * @link https://paystack.com/docs/api/payment-request#payment-requests
 */
class PaymentRequest
{
    private $client;

    public function __construct(PaystackClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * Create a payment request for a transaction on your integration
     *
     * @param string $customer Customer id or code
     * @param integer $amount Payment request amount. It should be used when line items and tax values aren't specified.
     * @param array $params Optional paramters. Refer to the docs
     * @return array
     * @link https://paystack.com/docs/api/payment-request#create
     */
    public function create(string $customer, int $amount, $params = []): array
    {
        $params['customer'] = $customer;
        $params['amount'] = $amount;
        return $this->client->post('paymentrequest', $params);
    }

    /**
     * List the payment requests available on your integration.
     *
     * @param array $params Query paramters. Refer to the docs
     * @return array
     * @link https://paystack.com/docs/api/payment-request#list
     */
    public function list($params = []): array
    {
        return $this->client->get('paymentrequest', $params);
    }

    /**
     * paymentrequest/:id_or_code
     *
     * @param string $id_or_code The payment request ID or code you want to fetch
     * @return array
     * @link https://paystack.com/docs/api/payment-request#fetch
     */
    public function fetch(string $id_or_code): array
    {
        return $this->client->get("paymentrequest/{$id_or_code}");
    }

    /**
     * Verify details of a payment request on your integration.
     *
     * @param string $code Payment Request code
     * @return array
     * @link https://paystack.com/docs/api/payment-request#verify
     */
    public function verify(string $code): array
    {
        return $this->client->get("paymentrequest/verify/{$code}");
    }

    /**
     * Send notification of a payment request to your customers
     *
     * @param string $code Payment Request code
     * @return array
     * @link https://paystack.com/docs/api/payment-request#send-notification
     */
    public function notify(string $code): array
    {
        return $this->client->post("paymentrequest/notify/{$code}");
    }

    /**
     * Get payment requests metric
     *
     * @return array
     * @link https://paystack.com/docs/api/payment-request#total
     */
    public function total(): array
    {
        return $this->client->get("paymentrequest/totals");
    }

    /**
     * Finalize a draft payment request
     *
     * @param string $code Payment Request code
     * @param boolean $send_notification Indicates whether Paystack sends an email notification to customer. Defaults to true
     * @return array
     * @link https://paystack.com/docs/api/payment-request#finalize
     */
    public function finalize(string $code, bool $send_notification): array
    {
        $params['send_notification'] = $send_notification;
        return $this->client->post("paymentrequest/finalize/{$code}", $params);
    }

    /**
     * Update a payment request details on your integration
     *
     * @param string $id_or_code Payment Request ID or slug
     * @param string $customer Customer id or code
     * @param integer $amount Payment request amount. Only useful if line items and tax values are ignored. endpoint will throw a friendly warning if neither is available.
     * @param array $params Optional paramters. Refer to the docs
     * @return array
     * @link https://paystack.com/docs/api/payment-request#update
     */
    public function update(string $id_or_code, string $customer, int $amount, $params = []): array
    {
        $params['customer'] = $customer;
        $params['amount'] = $amount;
        return $this->client->put("paymentrequest/{$id_or_code}", $params);
    }

    /**
     * Used to archive a payment request. A payment request will no longer be fetched on list or returned on verify.
     *
     * @param string $code Payment Request code
     * @return array
     * @link https://paystack.com/docs/api/payment-request#archive
     */
    public function archive(string $code): array
    {
        return $this->client->post("paymentrequest/archive/{$code}");
    }
}
