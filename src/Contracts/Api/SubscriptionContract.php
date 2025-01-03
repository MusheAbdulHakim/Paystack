<?php

declare(strict_types=1);

namespace MusheAbdulHakim\Paystack\Contracts\Api;

interface SubscriptionContract
{
    /**
     * Create Subscription
     * @param array<mixed> $params
     * @return array<mixed>|string
     */
    public function create(array $params = []): array|string;

    /**
     * List Subscriptions
     * @param array<mixed> $params
     * @return array<mixed>|string
     */
    public function list(array $params = []): array|string;

    /**
     * Fetch Subscription
     * @param string $id The subscription ID or code you want to fetch
     * @return array<mixed>|string
     */
    public function fetch(string $id): array|string;


    /**
     * Enable Subscription
     * @param string $code
     * @param string $token
     * @return array<mixed>|string
     */
    public function enable(string $code, string $token): array|string;

    /**
     * Disable Subscription
     * @param string $code
     * @param string $token
     * @return array<mixed>|string
     */
    public function disable(string $code, string $token): array|string;

    /**
     * Generate Update Subscription Link
     * @param string $code
     * @return array<mixed>|string
     */
    public function generateLink(string $code): array|string;

    /**
     * Send Update Subscription Link
     * @param string $code
     * @return array<mixed>|string
     */
    public function sendLink(string $code): array|string;
}
