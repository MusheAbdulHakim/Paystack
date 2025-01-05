<?php

declare(strict_types=1);

namespace MusheAbdulHakim\Paystack\Contracts\Api;

interface DisputeContract
{
    /**
     * List Disputes
     * @param array<mixed> $params
     * @return array<mixed>|string
     */
    public function list(array $params = []): array|string;

    /**
     * Fetch Dispute
     * @param string $id
     * @return array<mixed>|string
     */
    public function fetch(string $id): array|string;

    /**
     * List Transaction Disputes
     * @param string $id
     * @return array<mixed>|string
     */
    public function transactions(string $id): array|string;

    /**
     * Update Dispute
     * @param string $id
     * @param array<mixed> $params
     * @return array<mixed>|string
     */
    public function update(string $id, array $params = []): array|string;

    /**
     * Add Evidence
     * @param string $id
     * @param array<mixed> $params
     * @return array<mixed>|string
     */
    public function evidence(string $id, array $params = []): array|string;

    /**
     * Get Upload URL
     * @param string $id
     * @param array<string> $params
     * @return array<mixed>|string
     */
    public function uploadUrl(string $id, array $params = []): array|string;

    /**
     * Resolve Dispute
     * @param string $id
     * @param array<mixed> $params
     * @return array<mixed>|string
     */
    public function resolve(string $id, array $params): array|string;
    /**
     * Export Disputes
     * @param array<mixed> $params
     * @return array<mixed>|string
     */
    public function export(array $params = []): array|string;
}
