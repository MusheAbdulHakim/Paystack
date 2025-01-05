<?php

declare(strict_types=1);

namespace MusheAbdulHakim\Paystack\Contracts\Api;

interface VerificationContract
{
    /**
     * Resolve Account
     * @return array<mixed>|string
     */
    public function resolveAccount(string $account_number, string $bank_code): array|string;

    /**
     * Validate Account
     * @param array<mixed> $params
     * @return array<mixed>|string
     */
    public function validateAccount(array $params = []): array|string;

    /**
     * Resolve Card BIN
     * @param string $bin First 6 characters of card
     * @return array<mixed>|string
     */
    public function resolveCard(string $bin): array|string;
}
