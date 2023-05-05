<?php

declare(strict_types=1);

namespace Musheabdulhakim\Paystack\Api;

use Musheabdulhakim\Paystack\Contracts\PaystackClientInterface;

/**
 * The Subscriptions API allows you create and manage recurring payment on your integration.
 * @link https://paystack.com/docs/api/subscription#subscriptions
*/
class Subscription
{
    private $client;

    public function __construct(PaystackClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * Create a subscription on your integration
     *
     * @param string $customer Customer's email address or customer code
     * @param string $plan Plan code
     * @param string $authorization If customer has multiple authorizations, you can set the desired authorization you wish to use for this subscription here. If this is not supplied, the customer's most recent authorization would be used
     * @param array $params Optional parameters. Refer to the docs
     * @return array
     * @link https://paystack.com/docs/api/subscription#create
     */
    public function create(string $customer, string $plan, string $authorization, $params = []): array
    {
        $params['customer'] = $customer;
        $params['plan'] = $plan;
        $params['authorization'] = $authorization;
        return $this->client->post("subscription", $params);
    }

    /**
     * List subscriptions available on your integration.
     *
     * @param array $params Optional query parameters. Refer to the docs
     * @return array
     * @link https://paystack.com/docs/api/subscription#list
     */
    public function list($params = []): array
    {
        return $this->client->get("subscription", $params);
    }

    /**
     * Get details of a subscription on your integration.
     *
     * @param string $id_or_code The subscription ID or code you want to fetch
     * @return array
     *
     * @link https://paystack.com/docs/api/subscription#fetch
     */
    public function fetch(string $id_or_code): array
    {
        return $this->client->get("subscription/{$id_or_code}");
    }

    /**
     * Enable a subscription on your integration
     *
     * @param string $code Subscription code
     * @param string $token Email token
     * @return array
     * @link https://paystack.com/docs/api/subscription#enable
     */
    public function enable(string $code, string $token): array
    {
        $params['code'] = $code;
        $params['token'] = $token;
        return $this->client->post("subscription/enable", $params);
    }

    /**
     * Disable a subscription on your integration
     *
     * @param string $code Subscription code
     * @param string $token Email token
     * @return array
     * @link https://paystack.com/docs/api/subscription#disable
     */
    public function disable(string $code, string $token): array
    {
        $params['code'] = $code;
        $params['token'] = $token;
        return $this->client->post('subscription/disable', $params);
    }

    /**
     * Generate a link for updating the card on a subscription
     *
     * @param string $code Subscription code
     * @return array
     * @link https://paystack.com/docs/api/subscription#manage-link
     */
    public function link(string $code): array
    {
        return $this->client->get("subscription/{$code}/manage/link/");
    }

    /**
     * Email a customer a link for updating the card on their subscription
     *
     * @param string $code Subscription code
     * @return array
     * @link https://paystack.com/docs/api/subscription#manage-email
     */
    public function sendUpdateSubscriptionLink(string $code): array
    {
        return $this->client->post("subscription/{$code}/manage/email/");
    }
}
