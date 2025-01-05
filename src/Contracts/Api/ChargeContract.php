<?php

declare(strict_types=1);

namespace MusheAbdulHakim\Paystack\Contracts\Api;

interface ChargeContract
{
    /**
     * Create Charge
     * @param array<mixed> $params
     * @return array<mixed>|string
     */
    public function create(string $email, string $amount, array $params = []): array|string;

    /**
     * Submit PIN
     * @return array<mixed>|string
     */
    public function submitPin(string $pin, string $reference): array|string;

    /**
     * Submit OTP
     * @return array<mixed>|string
     */
    public function submitOTP(string $otp, string $reference): array|string;

    /**
     * Submit Phone
     * @return array<mixed>|string
     */
    public function submitPhone(string $phone, string $reference): array|string;

    /**
     * Submit Birthday
     * @return array<mixed>|string
     */
    public function submitBirthday(string $birthday, string $reference): array|string;

    /**
     * Submit Address
     * @param array<mixed> $params
     * @return array<mixed>|string
     */
    public function submitAddress(array $params = []): array|string;

    /**
     * Check Pending Charge
     * @return array<mixed>|string
     */
    public function checkPending(string $reference): array|string;


}
