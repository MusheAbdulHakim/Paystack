<?php

declare(strict_types=1);

namespace MusheAbdulHakim\Paystack\Contracts\Api;

interface RefundContract
{
    /**
     * Create Refund
     * @param array<mixed> $params
     * @return array<mixed>|string
     */
    public function create(string $transaction, array $params = []): array|string;

    /**
     * List Refunds
     * @param array<mixed> $params
     * @return array<mixed>|string
     */
    public function list(string $transaction, array $params = []): array|string;

    /**
     * Fetch Refund
     * @return array<mixed>|string
     */
    public function fetch(string $id): array|string;

}
