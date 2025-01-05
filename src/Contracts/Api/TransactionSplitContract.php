<?php

namespace MusheAbdulHakim\Paystack\Contracts\Api;

interface TransactionSplitContract
{
    /**
     * Create Split
     *
     * @param array<mixed> $params
     * @return array<mixed>|string
     * @see https://paystack.com/docs/api/split/#create
     */
    public function create(array $params = []): array|string;

    /**
     * List Split
     *
     * @param array<mixed> $params
     * @return array<mixed>|string
     * @see https://paystack.com/docs/api/split/#list
     */
    public function list(array $params = []): array|string;

    /**
     * Fetch Split
     *
     * @return array<mixed>|string
     * @see https://paystack.com/docs/api/split/#fetch
     */
    public function fetch(string $reference): array|string;

    /**
     * Update Split
     *
     * @param array<mixed> $params
     * @return array<mixed>|string
     * @see https://paystack.com/docs/api/split/#update
     */
    public function update(string $id, array $params = []): array|string;

    /**
     * Add/Update Subaccount Split
     *
     * @param array<mixed> $params
     * @return array<mixed>|string
     * @see https://paystack.com/docs/api/split/#add-subaccount
     */
    public function addSubAccount(string $id, array $params = []): array|string;

    /**
     * Remove Subaccount from Split
     *
     * @param array<string> $params
     * @return array<mixed>|string
     * @see Remove Subaccount from Split
     */
    public function removeSubAccount(string $id, array $params = []): array|string;
}
