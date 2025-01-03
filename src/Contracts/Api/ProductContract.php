<?php

declare(strict_types=1);

namespace MusheAbdulHakim\Paystack\Contracts\Api;

interface ProductContract
{
    /**
     * Create Product
     * @param array<mixed> $params
     * @return array<mixed>|string
     */
    public function create(array $params = []): array|string;

    /**
     * List Products
     * @param array<mixed> $params
     * @return array<mixed>|string
     */
    public function list(array $params = []): array|string;

    /**
     * Fetch Product
     * @param string $id
     * @return array<mixed>|string
     */
    public function fetch(string $id): array|string;

    /**
     * Update Product
     * @param string $id
     * @param array<mixed> $params
     * @return array<mixed>|string
     */
    public function update(string $id, array $params = []): array|string;
}
