<?php

declare(strict_types=1);

namespace Musheabdulhakim\Paystack\Api;

use Musheabdulhakim\Paystack\Contracts\PaystackClientInterface;

class Customer
{
    private $client;

    public function __construct(PaystackClientInterface $client)
    {
        $this->client = $client;
    }


    /**
     * Create a customer on your integration
     *
     * @param string $first_name Customer's first name
     * @param string $last_name Customer's last name
     * @param string $email Customer's email address
     * @param string|null $phone Customer's phone
     * @param array|null $metadata A set of key/value pairs that you can attach to the customer. It can be used to store additional information in a structured format.
     * @return mixed
     * @link https://paystack.com/docs/api/customer#create
     */
    public function create(string $first_name, string $last_name, string $email, ?string $phone, ?array $metadata): mixed
    {
        $params['first_name'] = $first_name;
        $params['last_name'] = $last_name;
        $params['email'] = $email;
        $params['phone'] = $phone;
        $params['metadata'] = $metadata;
        return $this->client->post("customer", $params);
    }

    /**
     * List customers available on your integration.
     *
     * @param array|null $params
     * @return mixed Query Parameters
     * @link https://paystack.com/docs/api/customer#list
     */
    public function list(?array $params): mixed
    {
        return $this->client->get('customer', $params);
    }
}
