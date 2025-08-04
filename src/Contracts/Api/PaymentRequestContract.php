<?php

namespace MusheAbdulHakim\Paystack\Contracts\Api;

interface PaymentRequestContract
{
    /**
     * Create Payment Request
     *
     * @param  array<mixed>  $params
     * @return array<mixed>|string
     */
    public function create(array $params = []): array|string;

    /**
     * List Payment Requests
     *
     * @param  array<mixed>  $params
     * @return array<mixed>|string
     */
    public function list(array $params = []): array|string;

    /**
     * Fetch Payment Request
     *
     * @return array<mixed>|string
     */
    public function fetch(string $id): array|string;

    /**
     * Verify Payment Request
     *
     * @return array<mixed>|string
     */
    public function verify(string $code): array|string;

    /**
     * Send Notification
     *
     * @return array<mixed>|string
     */
    public function notify(string $code): array|string;

    /**
     * Payment Request Total
     *
     * @return array<mixed>|string
     */
    public function total(): array|string;

    /**
     * Finalize Payment Request
     *
     * @return array<mixed>|string
     */
    public function finalize(string $code, bool $sendNotification): array|string;

    /**
     * Update Payment Request
     *
     * @param  array<mixed>  $params
     * @return array<mixed>|string
     */
    public function update(string $id, array $params = []): array|string;

    /**
     * Archive Payment Request
     *
     * @return array<mixed>|string
     */
    public function archive(string $code): array|string;
}
