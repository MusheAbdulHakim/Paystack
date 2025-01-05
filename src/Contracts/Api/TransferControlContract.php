<?php

declare(strict_types=1);

namespace MusheAbdulHakim\Paystack\Contracts\Api;

interface TransferControlContract
{
    /**
     * Check Balance
     * @return array<mixed>|string
     */
    public function balance(): array|string;

    /**
     * Fetch Balance Ledger
     * @return array<mixed>|string
     */
    public function ledger(): array|string;

    /**
     * Resend OTP
     * @return array<mixed>|string
     */
    public function resendOTP(string $transfer_code, string $reason): array|string;
    /**
     * Disable OTP
     * @return array<mixed>|string
     */
    public function disableOTP(): array|string;
    /**
     * Finalize Disable OTP
     * @return array<mixed>|string
     */
    public function finalizeDisableOTP(string $otp): array|string;

    /**
     * Enable OTP
     * @return array<mixed>|string
     */
    public function enableOTP(): array|string;
}
