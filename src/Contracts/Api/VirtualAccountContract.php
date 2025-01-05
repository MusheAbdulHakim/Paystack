<?php

namespace MusheAbdulHakim\Paystack\Contracts\Api;

interface VirtualAccountContract
{
    /**
     * Create Dedicated Virtual Account
     *
     * @param array<mixed> $params
     * @return array<mixed>|string
     */
    public function create(array $params = []): array|string;
    /**
     * Assign Dedicated Virtual Account
     *
     * @param array<mixed> $params
     * @return array<mixed>|string
     */
    public function assign(array $params = []): array|string;

    /**
     * List Dedicated Virtual Accounts
     * @param array<mixed> $params
     * @return array<mixed>|string
     */
    public function list(array $params = []): array|string;

    /**
     * Fetch Dedicated Virtual Account
     * @return array<mixed>|string
     */
    public function fetch(string $id): array|string;

    /**
     * Requery Dedicated Account
     * @param array<mixed> $params
     * @return array<mixed>|string
     */
    public function requery(array $params = []): array|string;

    /**
     * Deactivate Dedicated Account
     * @return array<mixed>|string
     */
    public function deactivate(string $id): array|string;

    /**
     * Split Dedicated Account Transaction
     * @param array<mixed> $params
     * @return array<mixed>|string
     */
    public function splitTransaction(string $customer, array $params = []): array|string;

    /**
     * Remove Split from Dedicated Account
     * @return array<mixed>|string
     */
    public function removeSplit(string $account): array|string;

    /**
     * Fetch Bank Providers
     * @return array<mixed>|string
     */
    public function bankProviders(): array|string;


}
