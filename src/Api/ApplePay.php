<?php

declare(strict_types=1);

namespace Musheabdulhakim\Paystack\Api;

use Musheabdulhakim\Paystack\Contracts\PaystackClientInterface;

/**
 * The Apple Pay API allows you register your application's top-level domain or subdomain.
 * @link https://paystack.com/docs/api/apple-pay#apple-pay
 */
class ApplePay
{
    private $client;

    public function __construct(PaystackClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * Register a top-level domain or subdomain for your Apple Pay integration.
     *
     * @param string $domainName Domain name to be registered
     * @return array
     * @link https://paystack.com/docs/api/apple-pay#register-domain
     */
    public function register(string $domainName): array
    {
        $params['domainName'] = $domainName;
        return $this->client->post('apple-pay/domain', $params);
    }

    /**
     * Lists all registered domains on your integration. Returns an empty array if no domains have been added.
     *
     * @param boolean $use_cursor Flag to enable cursor pagination on the endpoint
     * @param array $params Optional parameters. Refer to the docs
     * @return array
     * @link https://paystack.com/docs/api/apple-pay#list-domains
     */
    public function list(bool $use_cursor, $params = []): array
    {
        $params['use_cursor'] = $use_cursor;
        return $this->client->get('apple-pay/domain', $params);
    }

    /**
     * Unregister a top-level domain or subdomain previously used for your Apple Pay integration.
     *
     * @param string $domainName Domain name to be registered
     * @return array
     * @link https://paystack.com/docs/api/apple-pay#unregister-domain
     */
    public function unRegister(string $domainName): array
    {
        $params['domainName'] = $domainName;
        return $this->client->delete('apple-pay/domain', $params);
    }

}
