<?php

declare(strict_types=1);

namespace MusheAbdulHakim\Paystack\Contracts\Api;

interface SettlementContract
{
    /**
     * List Settlements
     *
     * @param  array<mixed>  $params
     * @return array<mixed>|string
     */
    public function list(array $params = []): array|string;

    /**
     * List Settlement Transactions
     *
     * @param  string  $id  The settlement ID in which you want to fetch its transactions
     * @param  array<mixed>  $params
     * @return array<mixed>|string
     */
    public function transactions(string $id, array $params = []): array|string;
}
