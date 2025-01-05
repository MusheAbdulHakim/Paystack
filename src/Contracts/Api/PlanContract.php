<?php

declare(strict_types=1);

namespace MusheAbdulHakim\Paystack\Contracts\Api;

interface PlanContract
{
    /**
     * Create Plan
     * @param array<mixed> $params
     * @return array<mixed>|string
     */
    public function create(array $params = []): array|string;

    /**
     * List Plans
     * @param array<mixed> $params
     * @return array<mixed>|string
     */
    public function list(array $params = []): array|string;

    /**
     * Fetch Plan
     * @param string $id Plan's ID or code
     * @return array<mixed>|string
     */
    public function fetch(string $id): array|string;

    /**
     * Update Plan
     * @param string $id Plan's ID or code
     * @param array<mixed> $params
     * @return array<mixed>|string
     */
    public function update(string $id, array $params = []): array|string;
}
