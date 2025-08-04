<?php

declare(strict_types=1);

namespace MusheAbdulHakim\Paystack\Api;

use MusheAbdulHakim\Paystack\Api\Concerns\Transportable;
use MusheAbdulHakim\Paystack\Contracts\Api\SubscriptionContract;
use MusheAbdulHakim\Paystack\ValueObjects\Transporter\Payload;

final class Subscription implements SubscriptionContract
{
    use Transportable;

    public function create(array $params = []): array|string
    {
        $payload = Payload::post('subscription', $params);

        return $this->transporter->requestObject($payload)->data();
    }

    public function list(array $params = []): array|string
    {
        $payload = Payload::get('subscription', $params);

        return $this->transporter->requestObject($payload)->data();
    }

    public function fetch(string $id): array|string
    {
        $payload = Payload::get("subscription/$id");

        return $this->transporter->requestObject($payload)->data();
    }

    public function enable(string $code, string $token): array|string
    {
        $params['code'] = $code;
        $params['token'] = $token;
        $payload = Payload::post('subscription/enable', $params);

        return $this->transporter->requestObject($payload)->data();
    }

    public function disable(string $code, string $token): array|string
    {
        $params['code'] = $code;
        $params['token'] = $token;
        $payload = Payload::post('subscription/disable', $params);

        return $this->transporter->requestObject($payload)->data();
    }

    public function generateLink(string $code): array|string
    {
        $payload = Payload::get("subscription/$code/manage/link");

        return $this->transporter->requestObject($payload)->data();
    }

    public function sendLink(string $code): array|string
    {
        $payload = Payload::post("subscription/$code/manage/email");

        return $this->transporter->requestObject($payload)->data();
    }
}
