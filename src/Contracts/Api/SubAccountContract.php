<?php

declare(strict_types=1);

namespace MusheAbdulHakim\Paystack\Contracts\Api;

interface SubAccountContract
{
    /**
     * Create Subaccount
     * @param array<mixed> $params
     * @return array<mixed>|string
     */
    public function create(array $params = []): array|string;

    /**
     * List Subaccounts
     * @param array<mixed> $params
     * @return array<mixed>|string
     */
    public function list(array $params = []): array|string;

    /**
     * Fetch Subaccount
     * @param string $id The subaccount ID or code you want to fetch
     * @return array<mixed>|string
     */
    public function fetch(string $id): array|string;

    /**
     * Update update
     * @param string $id The subaccount ID or code you want to fetch
     * @param array<mixed> $params
     * @return array<mixed>|string
     */
    public function update(string $id, array $params = []): array|string;


}
