<?php

namespace MusheAbdulHakim\Paystack\Contracts\Api;

interface PaymentPageContract
{
    /**
     * Create Payment Page
     * @param array<mixed> $params
     * @return array<mixed>|string
     */
    public function create(string $name, array $params = []): array|string;

    /**
     * List Payment Pages
     * @param array<mixed> $params
     * @return array<mixed>|string
     */
    public function list(array $params = []): array|string;

    /**
     * Fetch Payment Page
     * @param string $id The page ID or slug you want to fetch
     * @return array<mixed>|string
     */
    public function fetch(string $id): array|string;

    /**
     * Update Payment Page
     * @param array<mixed> $params
     * @return array<mixed>|string
     */
    public function update(string $id, array $params = []): array|string;

    /**
     * Check Slug Availability
     * @return array<mixed>|string
     */
    public function checkSlug(string $slug): array|string;

    /**
     * Add Products
     * @param array<int> $products
     * @return array<mixed>|string
     */
    public function addProduct(string $id, array $products = []): array|string;
}
