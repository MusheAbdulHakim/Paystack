<?php

declare(strict_types=1);

namespace MusheAbdulHakim\Paystack\Contracts\Api;

interface MiscellaneousContract
{
    /**
     * List Banks
     * @param array<mixed> $params
     * @return array<mixed>|string
     */
    public function banks(array $params = []): array|string;

    /**
     * List Countries
     * @return array<mixed>|string
     */
    public function countries(): array|string;

    /**
     * List States (AVS)
     * @param array<mixed> $params
     * @return array<mixed>|string
     */
    public function states(array $params = []): array|string;

}
