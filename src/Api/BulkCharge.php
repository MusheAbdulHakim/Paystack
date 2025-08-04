<?php

declare(strict_types=1);

namespace MusheAbdulHakim\Paystack\Api;

use MusheAbdulHakim\Paystack\Api\Concerns\Transportable;
use MusheAbdulHakim\Paystack\Contracts\Api\BulkChargeContract;
use MusheAbdulHakim\Paystack\ValueObjects\Transporter\Payload;

final class BulkCharge implements BulkChargeContract
{
    use Transportable;

    public function init(array $params = []): array|string
    {
        $payload = Payload::post('bulkcharge', $params);

        return $this->transporter->requestObject($payload)->data();
    }

    public function list(array $params = []): array|string
    {
        $payload = Payload::get('bulkcharge', $params);

        return $this->transporter->requestObject($payload)->data();
    }

    public function fetch(string $id): array|string
    {
        $payload = Payload::get("bulkcharge/$id");

        return $this->transporter->requestObject($payload)->data();
    }

    public function batch(string $id, array $params = []): array|string
    {
        $payload = Payload::get("bulkcharge/$id/charges", $params);

        return $this->transporter->requestObject($payload)->data();
    }

    public function pause(string $code): array|string
    {
        $payload = Payload::get("bulkcharge/pause/$code");

        return $this->transporter->requestObject($payload)->data();
    }

    public function resume(string $code): array|string
    {
        $payload = Payload::get("/bulkcharge/resume/$code");

        return $this->transporter->requestObject($payload)->data();
    }
}
