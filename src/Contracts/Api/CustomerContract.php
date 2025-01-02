<?php

namespace MusheAbdulHakim\Paystack\Contracts\Api;

interface CustomerContract
{
    /**
     * Create Customer
     * @param array<mixed> $params
     * @return array<mixed>|string
     */
    public function create(array $params = []): array|string;

    /**
     * List Customers
     * @param array<mixed> $params
     * @return array<mixed>|string
     */
    public function list(array $params = []): array|string;

    /**
     * Fetch Customer
     * @return array<mixed>|string
     */
    public function fetch(string $emailOrCode): array|string;

    /**
     * Update Customer
     * @param array<mixed> $params
     * @return array<mixed>|string
     */
    public function update(string $code, array $params = []): array|string;

    /**
     * Validate Customer
     * @param array<mixed> $params
     * @return array<mixed>|string
     */
    public function validate(string $code, array $params = []): array|string;

    /**
     * Whitelist/Blacklist Customer
     *
     * @return array<mixed>|string
     */
    public function status(string $customer, string $action): array|string;

    /**
     * White Customer
     * @return array<mixed>|string
     */
    public function whiteList(string $customer): array|string;

    /**
     * Blacklist Customer
     * @return array<mixed>|string
     */
    public function blackList(string $customer): array|string;

    /**
     * Deactivate Authorization
     * @param string $code Authorization code to be deactivated
     * @return array<mixed>|string
     */
    public function deactivate(string $code): array|string;
}
