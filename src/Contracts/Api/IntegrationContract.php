<?php

declare(strict_types=1);

namespace MusheAbdulHakim\Paystack\Contracts\Api;

interface IntegrationContract
{
    /**
     * Fetch Timeout
     *
     * @return array<mixed>|string
     */
    public function fetchPayment(): array|string;

    /**
     * Update Timeout
     *
     * @return array<mixed>|string
     */
    public function updatePayment(int $timeout): array|string;
}
