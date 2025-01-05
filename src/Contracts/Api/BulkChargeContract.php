<?php

declare(strict_types=1);

namespace MusheAbdulHakim\Paystack\Contracts\Api;

interface BulkChargeContract
{
    /**
     * Initiate Bulk Charge
     * @param array<mixed> $params
     * @return array<mixed>|string
     */
    public function init(array $params = []): array|string;

    /**
     * List Bulk Charge Batches
     * @param array<mixed> $params
     * @return array<mixed>|string
     */
    public function list(array $params = []): array|string;

    /**
     * Fetch Bulk Charge Batch
     * @return array<mixed>|string
     */
    public function fetch(string $id): array|string;

    /**
     * Fetch Charges in a Batch
     * @param array<mixed> $params
     * @return array<mixed>|string
     */
    public function batch(string $id, array $params = []): array|string;

    /**
     * Pause Bulk Charge Batch
     * @return array<mixed>|string
     */
    public function pause(string $code): array|string;

    /**
     * Resume Bulk Charge Batch
     * @return array<mixed>|string
     */
    public function resume(string $code): array|string;


}
