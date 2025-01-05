<?php

namespace MusheAbdulHakim\Paystack\Contracts\Api;

interface ApplePayContract
{
    /**
     * Register Domain
     * @return array<mixed>|string
     */
    public function register(string $domain): array|string;

    /**
     * List Domains
     * @param array<mixed> $params
     * @return array<mixed>|string
     */
    public function list(array $params = []): array|string;
    /**
     * Unregister Domain
     * @return array<mixed>|string
     */
    public function unregister(string $domain): array|string;
}
