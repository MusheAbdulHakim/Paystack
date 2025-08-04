<?php

declare(strict_types=1);

namespace MusheAbdulHakim\Paystack\Api;

use MusheAbdulHakim\Paystack\Api\Concerns\Transportable;
use MusheAbdulHakim\Paystack\Contracts\Api\TransferContract;
use MusheAbdulHakim\Paystack\ValueObjects\Transporter\Payload;

final class Transfer implements TransferContract
{
    use Transportable;

    public function init(array $params = []): array|string
    {
        $payload = Payload::post('transfer', $params);

        return $this->transporter->requestObject($payload)->data();
    }

    public function finalize(string $code, string $otp): array|string
    {

        $params['transfer_code'] = $code;
        $params['otp'] = $otp;
        $payload = Payload::post('transfer/finalize_transfer', $params);

        return $this->transporter->requestObject($payload)->data();
    }

    public function bulk(string $source, array $transfers = []): array|string
    {
        $params['source'] = $source;
        $params['transfers'] = $transfers;
        $payload = Payload::post('transfer/bulk', $params);

        return $this->transporter->requestObject($payload)->data();
    }

    public function list(array $params = []): array|string
    {
        $payload = Payload::get('transfer', $params);

        return $this->transporter->requestObject($payload)->data();
    }

    public function fetch(string $id): array|string
    {
        $payload = Payload::get("transfer/$id");

        return $this->transporter->requestObject($payload)->data();
    }

    public function verify(string $reference): array|string
    {
        $payload = Payload::get("transfer/verify/$reference");

        return $this->transporter->requestObject($payload)->data();
    }
}
