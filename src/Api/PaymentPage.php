<?php

declare(strict_types=1);

namespace Musheabdulhakim\Paystack\Api;

use Musheabdulhakim\Paystack\Contracts\PaystackClientInterface;

/**
 * The Payment Pages API provides a quick and secure way to collect payment for products.
 * @link https://paystack.com/docs/api/page#payment-pages
 *
 */
class PaymentPage
{
    private $client;

    public function __construct(PaystackClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * Create a payment page on your integration
     *
     * @param string $name Name of page
     * @param array $params Optional parameters. Refer to the docs
     * @return array
     * @link https://paystack.com/docs/api/page#create
     */
    public function create(string $name, $params = []): array
    {
        $params['name'] = $name;
        return $this->client->post('page', $params);
    }

    /**
     * List payment pages available on your integration.
     *
     * @param array $params Optional query parameters. Refer to the docs
     * @return array
     */
    public function list($params = []): array
    {
        return $this->client->get('page', $params);
    }

    /**
     * Get details of a payment page on your integration.
     *
     * @param string $id_or_slug The page ID or slug you want to fetch
     * @return array
     */
    public function fetch(string $id_or_slug): array
    {
        return $this->client->get("page/{$id_or_slug}");
    }

    /**
     * Update a payment page details on your integration
     *
     * @param string $id_or_slug Page ID or slug
     * @param string $name Name of page.
     * @param string $description A description for this page
     * @param array $params Optional parameters. Refer to the docs
     * @return array
     * @link https://paystack.com/docs/api/page#update
     */
    public function update(string $id_or_slug, string $name, string $description, $params = []): array
    {
        $params['name'] = $name;
        $params['description'] = $description;
        return $this->client->put("page/{$id_or_slug}", $params);
    }

    /**
     * Check the availability of a slug for a payment page.
     *
     * @param string $slug URL slug to be confirmed
     * @return array
     * @link https://paystack.com/docs/api/page#check-slug
     */
    public function isSlugAvailable(string $slug): array
    {
        return $this->client->get("page/check_slug_availability/{$slug}");
    }

    /**
     * Check the availability of a slug for a payment page.
     *
     * @param string $slug URL slug to be confirmed
     * @return array
     * @link https://paystack.com/docs/api/page#check-slug
     */
    public function checkSlugAvailable(string $slug): array
    {
        return $this->isSlugAvailable($slug);
    }

    /**
     * Add products to a payment page
     *
     * @param integer $id Id of the payment page
     * @param array $product Ids of all the products
     * @return array
     * @link https://paystack.com/docs/api/page#add-products
     */
    public function addProducts(int $id, array $product): array
    {
        $params['product'] = $product;
        return $this->client->post("page/{$id}/product", $params);
    }

}
