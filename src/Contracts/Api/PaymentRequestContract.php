<?php

namespace MusheAbdulHakim\Paystack\Contracts\Api;

interface PaymentRequestContract
{
    /**
     * Create Payment Request
     * @param array<mixed> $params
     * @return array<mixed>|string
     */
    public function create(array $params = []): array|string;

    /**
     * List Payment Requests
     * @param array<mixed> $params
     * @return array<mixed>|string
     */
    public function list(array $params = []): array|string;

    /**
     * Fetch Payment Request
     * @param string $id
     * @return array<mixed>|string
     */
    public function fetch(string $id): array|string;

    /**
     * Verify Payment Request
     * @param string $code
     * @return array<mixed>|string
     */
    public function verify(string $code): array|string;

    /**
     * Send Notification
     * @param string $code
     * @return array<mixed>|string
     */
    public function notify(string $code): array|string;

    /**
     * Payment Request Total
     * @return array<mixed>|string
     */
    public function total(): array|string;

    /**
     * Finalize Payment Request
     * @param string $code
     * @param bool $sendNotification
     * @return array<mixed>|string
     */
    public function finalize(string $code, bool $sendNotification): array|string;

    /**
     * Update Payment Request
     * @param string $id
     * @param array<mixed> $params
     * @return array<mixed>|string
     */
    public function update(string $id, array $params = []): array|string;

    /**
     * Archive Payment Request
     * @param string $code
     * @return array<mixed>|string
     */
    public function archive(string $code): array|string;

}
