<?php

declare(strict_types=1);

namespace MusheAbdulHakim\Paystack\Api;

use MusheAbdulHakim\Paystack\Api\Concerns\Transportable;
use MusheAbdulHakim\Paystack\Contracts\Api\ChargeContract;
use MusheAbdulHakim\Paystack\ValueObjects\Transporter\Payload;

final class Charge implements ChargeContract
{
    use Transportable;

    public function create(string $email, string $amount, array $params = []): array|string
    {
        $params['email'] = $email;
        $params['amount'] = $amount;
        $payload = Payload::post("charge", $params);
        return $this->transporter->requestObject($payload)->data();
    }

    public function submitPin(string $pin, string $reference): array|string
    {
        $params['pin'] = $pin;
        $params['reference'] = $reference;
        $payload = Payload::post("charge/submit_pin", $params);
        return $this->transporter->requestObject($payload)->data();
    }

    public function submitOTP(string $otp, string $reference): array|string
    {

        $params['otp'] = $otp;
        $params['reference'] = $reference;
        $payload = Payload::post("charge/submit_otp", $params);
        return $this->transporter->requestObject($payload)->data();
    }

    public function submitPhone(string $phone, string $reference): array|string
    {
        $params['phone'] = $phone;
        $params['reference'] = $reference;
        $payload = Payload::post("charge/submit_phone", $params);
        return $this->transporter->requestObject($payload)->data();
    }

    public function submitBirthday(string $birthday, string $reference): array|string
    {
        $params['birthday'] = $birthday;
        $params['reference'] = $reference;
        $payload = Payload::post("charge/submit_birthday", $params);
        return $this->transporter->requestObject($payload)->data();
    }

    public function submitAddress(array $params = []): array|string
    {
        $payload = Payload::post("charge/submit_address", $params);
        return $this->transporter->requestObject($payload)->data();
    }

    public function checkPending(string $reference): array|string
    {
        $payload = Payload::get("charge/$reference");
        return $this->transporter->requestObject($payload)->data();
    }
}
