<?php

declare(strict_types=1);

namespace MusheAbdulHakim\Paystack\Api;

use MusheAbdulHakim\Paystack\Api\Concerns\Transportable;
use MusheAbdulHakim\Paystack\Contracts\Api\DisputeContract;
use MusheAbdulHakim\Paystack\ValueObjects\Transporter\Payload;

final class Dispute implements DisputeContract
{
    use Transportable;

    public function list(array $params = []): array|string
    {
        $payload = Payload::get("dispute", $params);
        return $this->transporter->requestObject($payload)->data();
    }


    public function fetch(string $id): array|string
    {
        $payload = Payload::get("dispute/$id");
        return $this->transporter->requestObject($payload)->data();
    }

    public function transactions(string $id): array|string
    {
        $payload = Payload::get("dispute/transaction/$id");
        return $this->transporter->requestObject($payload)->data();
    }

    public function update(string $id, array $params = []): array|string
    {
        $payload = Payload::put("dispute/$id", $params);
        return $this->transporter->requestObject($payload)->data();
    }

    public function evidence(string $id, array $params = []): array|string
    {
        $payload = Payload::post("dispute/$id/evidence", $params);
        return $this->transporter->requestObject($payload)->data();
    }

    public function uploadUrl(string $id, array $params = []): array|string
    {
        $payload = Payload::get("dispute/$id/upload_url", $params);
        return $this->transporter->requestObject($payload)->data();
    }

    public function resolve(string $id, array $params): array|string
    {
        $payload = Payload::put("dispute/$id/resolve", $params);
        return $this->transporter->requestObject($payload)->data();
    }

    public function export(array $params = []): array|string
    {
        $payload = Payload::get("dispute/export", $params);
        return $this->transporter->requestObject($payload)->data();
    }

}
