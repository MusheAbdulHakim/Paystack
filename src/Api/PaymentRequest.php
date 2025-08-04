<?php

declare(strict_types=1);

namespace MusheAbdulHakim\Paystack\Api;

use MusheAbdulHakim\Paystack\Api\Concerns\Transportable;
use MusheAbdulHakim\Paystack\Contracts\Api\PaymentRequestContract;
use MusheAbdulHakim\Paystack\ValueObjects\Transporter\Payload;

final class PaymentRequest implements PaymentRequestContract
{
    use Transportable;

    public function create(array $params = []): array|string
    {
        $payload = Payload::post('paymentrequest', $params);

        return $this->transporter->requestObject($payload)->data();
    }

    public function list(array $params = []): array|string
    {
        $payload = Payload::get('paymentrequest', $params);

        return $this->transporter->requestObject($payload)->data();
    }

    public function fetch(string $id): array|string
    {
        $payload = Payload::get("paymentrequest/$id");

        return $this->transporter->requestObject($payload)->data();
    }

    public function verify(string $code): array|string
    {
        $payload = Payload::get("paymentrequest/verify/$code");

        return $this->transporter->requestObject($payload)->data();
    }

    public function notify(string $code): array|string
    {
        $payload = Payload::post("paymentrequest/notify/$code");

        return $this->transporter->requestObject($payload)->data();
    }

    public function total(): array|string
    {
        $payload = Payload::get('paymentrequest/totals');

        return $this->transporter->requestObject($payload)->data();
    }

    public function finalize(string $code, bool $sendNotification): array|string
    {
        $params['send_notification'] = $sendNotification;
        $payload = Payload::post("paymentrequest/finalize/$code", $params);

        return $this->transporter->requestObject($payload)->data();
    }

    public function update(string $id, array $params = []): array|string
    {
        $payload = Payload::post("paymentrequest/$id", $params);

        return $this->transporter->requestObject($payload)->data();
    }

    public function archive(string $code): array|string
    {
        $payload = Payload::post("paymentrequest/archive/$code");

        return $this->transporter->requestObject($payload)->data();
    }
}
