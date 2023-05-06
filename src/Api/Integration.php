<?php
declare(strict_types=1);

namespace Musheabdulhakim\Paystack\Api;

use Musheabdulhakim\Paystack\Contracts\PaystackClientInterface;

/**
 * The Integration Class allows you manage some settings on your integration.
 * @link https://paystack.com/docs/api/integration#integration
 */
class Integration
{
    private $client;

    public function __construct(PaystackClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * Fetch the payment session timeout on your integration
     *
     * @return array
     * @link https://paystack.com/docs/api/integration#fetch-timeout
     */
    public function timeout(): array
    {
        return $this->client->get("integration/payment_session_timeout");
    }

    /**
     * Update the payment session timeout on your integration
     *
     * @param integer $timeout
     * @return array
     * @link https://paystack.com/docs/api/integration#update-timeout
     */
    public function update(int $timeout): array
    {
        $params['timeout'] = $timeout;
        return $this->client->put("integration/payment_session_timeout", $params);
    }
}
