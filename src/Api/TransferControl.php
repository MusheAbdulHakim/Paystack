<?php

declare(strict_types=1);

namespace MusheAbdulHakim\Paystack\Api;

use MusheAbdulHakim\Paystack\Api\Concerns\Transportable;
use MusheAbdulHakim\Paystack\ValueObjects\Transporter\Payload;
use MusheAbdulHakim\Paystack\Contracts\Api\TransferControlContract;

final class TransferControl implements TransferControlContract
{
    use Transportable;

    public function balance(): array|string
    {
        $payload = Payload::get("balance");
        return $this->transporter->requestObject($payload)->data();
    }

    public function ledger(): array|string
    {
        $payload = Payload::get("balance/ledger");
        return $this->transporter->requestObject($payload)->data();
    }

    public function resendOTP(string $transfer_code, string $reason): array|string
    {
        $params['transfer_code'] = $transfer_code;
        $params['reason'] = $reason;
        $payload = Payload::post("transfer/resend_otp", $params);
        return $this->transporter->requestObject($payload)->data();
    }

    public function disableOTP(): array|string
    {
        $payload = Payload::post("transfer/disable_otp");
        return $this->transporter->requestObject($payload)->data();
    }

    public function finalizeDisableOTP(string $otp): array|string
    {
        $params['otp'] = $otp;
        $payload = Payload::post("transfer/disable_otp_finalize", $params);
        return $this->transporter->requestObject($payload)->data();
    }

    public function enableOTP(): array|string
    {
        $payload = Payload::post("transfer/enable_otp");
        return $this->transporter->requestObject($payload)->data();
    }
}
