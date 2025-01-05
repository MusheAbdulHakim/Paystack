<?php

declare(strict_types=1);

namespace MusheAbdulHakim\Paystack\Api;

use MusheAbdulHakim\Paystack\Api\Concerns\Transportable;
use MusheAbdulHakim\Paystack\ValueObjects\Transporter\Payload;
use MusheAbdulHakim\Paystack\Contracts\Api\VerificationContract;

final class Verification implements VerificationContract
{
    use Transportable;

    public function resolveAccount(string $account_number, string $bank_code): array|string
    {
        $params['account_number'] = $account_number;
        $params['bank_code'] = $bank_code;
        $payload = Payload::get("bank/resolve", $params);
        return $this->transporter->requestObject($payload)->data();
    }

    public function validateAccount(array $params = []): array|string
    {

        $payload = Payload::post("bank/validate", $params);
        return $this->transporter->requestObject($payload)->data();
    }

    public function resolveCard(string $bin): array|string
    {
        $payload = Payload::get("decision/bin/$bin");
        return $this->transporter->requestObject($payload)->data();
    }

}
