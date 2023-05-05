<?php

declare(strict_types=1);

namespace Musheabdulhakim\Paystack\Api;

use Musheabdulhakim\Paystack\Contracts\PaystackClientInterface;

/**
 * The Plans API allows you create and manage installment payment options on your integration.
 * @link https://paystack.com/docs/api/plan#plans
 */
class Plan
{
    private $client;

    public function __construct(PaystackClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * Create a plan on your integration
     *
     * @param string $name Name of plan
     * @param integer $amount Amount should be in kobo if currency is NGN, pesewas, if currency is GHS, and cents, if currency is ZAR
     * @param string $interval Interval in words. Valid intervals are: daily, weekly, monthly,biannually, annually.
     * @param array $params Optional parameters. Refer to the docs.
     * @return array
     * @link https://paystack.com/docs/api/plan#create
     */
    public function create(string $name, int $amount, string $interval, $params = []): array
    {
        $params['name'] = $name;
        $params['amount'] = $amount;
        $params['interval'] = $interval;
        return $this->client->post('plan', $params);
    }

    /**
     * List plans available on your integration.
     *
     * @param array $params Optional parameters. You can refer to the docs
     * @return array
     * @link https://paystack.com/docs/api/plan#list
     */
    public function list($params = []): array
    {
        return $this->client->get('plan', $params);
    }

    /**
     * Get details of a plan on your integration.
     *
     * @param string $id_or_code The plan ID or code you want to fetch
     * @return array
     * @link https://paystack.com/docs/api/plan#fetch
     */
    public function fetch(string $id_or_code): array
    {
        return $this->client->get("plan/{$id_or_code}");
    }

    /**
     * Update a plan details on your integration
     *
     * @param string $id_or_code Plan's ID or code
     * @param string $name Name of plan
     * @param integer $amount Amount should be in kobo if currency is NGN and pesewas for GHS
     * @param string $interval
     * @param array $params
     * @return array
     */
    public function update(string $id_or_code, string $name, int $amount, string $interval, $params = []): array
    {
        $params['name'] = $name;
        $params['amount'] = $amount;
        $params['interval'] = $interval;
        return $this->client->put("plan/{$id_or_code}", $params);
    }

}
