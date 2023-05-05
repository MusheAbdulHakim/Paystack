<?php

declare(strict_types=1);

namespace Musheabdulhakim\Paystack\Api;

use Musheabdulhakim\Paystack\Contracts\PaystackClientInterface;

/**
 * The Products API allows you create and manage inventories on your integration.
 * @license https://paystack.com/docs/api/product#products
 */
class Product
{
    private $client;

    public function __construct(PaystackClientInterface $client)
    {
        $this->client = $client;
    }


    /**
     * Create a product on your integration
     *
     * @param string $name Name of product
     * @param string $description A description for this product
     * @param integer $price Price should be in kobo if currency is NGN, pesewas, if currency is GHS, and cents, if currency is ZAR
     * @param string $currency Currency in which price is set. Allowed values are: NGN, GHS, ZAR or USD
     * @param array $params Optional parameters. Refer to the docs
     * @return array
     * @link https://paystack.com/docs/api/product#create
     */
    public function create(string $name, string $description, int $price, string $currency, $params = []): array
    {
        $params['name'] = $name;
        $params['description'] = $description;
        $params['price'] = $price;
        $params['currency'] = $currency;
        return $this->client->post("product", $params);
    }

    /**
     * List products available on your integration.
     *
     * @param array $params Query parameters. Refer to the docs
     * @return array
     * @link https://paystack.com/docs/api/product#list
     */
    public function list($params = []): array
    {
        return $this->client->get('product', $params);
    }

    /**
     * Get details of a product on your integration.
     *
     * @param string $id The product ID you want to fetch
     * @return array
     * @link https://paystack.com/docs/api/product#fetch
     */
    public function fetch(string $id): array
    {
        return $this->client->get("/product/{$id}");
    }

    /**
     * Update a product details on your integration
     *
     * @param string $id Product ID
     * @param string $name Name of product
     * @param string $description A description for this product
     * @param integer $price Price should be in kobo if currency is NGN, pesewas, if currency is GHS, and cents, if currency is ZAR
     * @param string $currency Currency in which price is set. Allowed values are: NGN, GHS, ZAR or USD. Default value is USD
     * @param array $params Optional parameters. Refer to the docs
     * @return array
     * @link https://paystack.com/docs/api/product#update
     */
    public function update(string $id, string $name, string $description, int $price, string $currency = "USD", $params = []): array
    {
        $params['name'] = $name;
        $params['description'] = $description;
        $params['price'] = $price;
        $params['currency'] = $currency;
        return $this->client->put("product/{$id}", $params);
    }
}
