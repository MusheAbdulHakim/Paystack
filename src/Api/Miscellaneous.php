<?php
declare(strict_types=1);

namespace Musheabdulhakim\Paystack\Api;

use Musheabdulhakim\Paystack\Contracts\PaystackClientInterface;

/**
 * The Miscellaneous API are supporting APIs that can be used to provide more details to other APIs.
 * @link https://paystack.com/docs/api/miscellaneous#miscellaneous
 */
class Miscellaneous
{
    private $client;

    public function __construct(PaystackClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * Get a list of all supported banks and their properties
     *
     * @param string|null $country The country from which to obtain the list of supported banks. e.g country=ghana or country=nigeria
     * @param string|null $currency Any of NGN, USD, GHS or ZAR
     * @param array $params
     * @return array
     * @link https://paystack.com/docs/api/miscellaneous#bank
     */
    public function banks(string $country = null, string $currency = null, $params = []): array
    {
        $params['country'] = $country ?? null;
        $params['currency'] = $currency ?? null;
        return $this->client->get("bank", $params);
    }

    /**
     * Gets a list of countries that Paystack currently supports
     *
     * @return array
     * @link https://paystack.com/docs/api/miscellaneous#country
     */
    public function countries(): array
    {
        return $this->client->get("country");
    }

    /**
     * Get a list of states for a country for address verification.
     *
     * @param string $country The country code of the states to list. It is gotten after the charge request.
     * @return array
     * @link https://paystack.com/docs/api/miscellaneous#avs-states
     */
    public function states(string $country): array
    {
        $params['country'] = $country;
        return $this->client->get("address_verification/states", $params);
    }
}
