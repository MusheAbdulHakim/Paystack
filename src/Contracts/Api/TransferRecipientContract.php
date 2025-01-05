<?php

declare(strict_types=1);

namespace MusheAbdulHakim\Paystack\Contracts\Api;

interface TransferRecipientContract
{
    /**
     * Create Transfer Recipient
     * @param array<mixed> $params
     * @return array<mixed>|string
     */
    public function create(array $params = []): array|string;

    /**
     * Bulk Create Transfer Recipient
     * @param array<array<string>> $batch array of transfer recipients
     * @return array<mixed>|string
     */
    public function bulk(array $batch = []): array|string;

    /**
     * List Transfer Recipients
     * @param array<mixed> $params
     * @return array<mixed>|string
     */
    public function list(array $params = []): array|string;

    /**
     * Fetch Transfer Recipient
     * @param string $id An ID or code for the recipient whose details you want to receive.
     * @return array<mixed>|string
     */
    public function fetch(string $id): array|string;

    /**
     * Update Transfer Recipient
     * @param string $id Transfer Recipient's ID or code
     * @param array<mixed> $params
     * @return array<mixed>|string
     */
    public function update(string $id, array $params = []): array|string;

    /**
     * Delete Transfer Receipient
     * @param string $id An ID or code for the recipient who you want to delete.
     * @return array<mixed>|string
     */
    public function delete(string $id): array|string;

}
