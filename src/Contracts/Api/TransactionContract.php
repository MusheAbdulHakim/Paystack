<?php

namespace MusheAbdulHakim\Paystack\Contracts\Api;

interface TransactionContract
{
    /**
     * Initialize Transaction
     *
     * @param array<mixed> $params
     * @return array<mixed>|string
     * @see https://paystack.com/docs/api/transaction/#initialize
     */
    public function initialize(array $params = []): array|string;

    /**
     * Verify Transaction
     *
     * @return array<mixed>|string
     * https://paystack.com/docs/api/transaction/#verify
     */
    public function verify(string $reference): array|string;

    /**
     * List Transaction
     *
     * @param array<mixed> $params
     * @return array<mixed>|string
     * https://paystack.com/docs/api/transaction/#list
     */
    public function list(array $params = []): array|string;


    /**
     * Fetch Transaction
     * @return array<mixed>|string
     */
    public function fetch(int $id): array|string;

    /**
     * Charge Authorization
     *
     * @param array<mixed> $params
     * @return array<mixed>|string
     * @see https://paystack.com/docs/api/transaction/#charge-authorization
     */
    public function chargeAuth(array $params = []): array|string;

    /**
     * View Transaction Timeline
     *
     * @return array<mixed>|string
     * @see https://paystack.com/docs/api/transaction/#view-timeline
     */
    public function view(string $id): array|string;

    /**
     * Transaction Totals
     *
     * @param array<string> $params
     * @return array<mixed>|string
     * @see https://paystack.com/docs/api/transaction/#totals
     */
    public function totals(array $params = []): array|string;

    /**
     * Export Transaction
     *
     * @param array<mixed> $params
     * @return array<mixed>|string
     * @see https://paystack.com/docs/api/transaction/#export
     */
    public function export(array $params = []): array|string;

    /**
     * Partial Debit
     * @param array<mixed> $params
     * @return array<mixed>|string
     * @see https://paystack.com/docs/api/transaction/#partial-debit
     */
    public function partialDebit(array $params = []): array|string;
}
