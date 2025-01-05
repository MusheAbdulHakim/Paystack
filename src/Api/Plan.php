<?php

declare(strict_types=1);

namespace MusheAbdulHakim\Paystack\Api;

use MusheAbdulHakim\Paystack\Api\Concerns\Transportable;
use MusheAbdulHakim\Paystack\Contracts\Api\PlanContract;
use MusheAbdulHakim\Paystack\ValueObjects\Transporter\Payload;

final class Plan implements PlanContract
{
    use Transportable;

    public function create(array $params = []): array|string
    {
        $payload = Payload::post("plan", $params);
        return $this->transporter->requestObject($payload)->data();
    }

    public function list(array $params = []): array|string
    {
        $payload = Payload::get("plan", $params);
        return $this->transporter->requestObject($payload)->data();
    }

    public function fetch(string $id): array|string
    {
        $payload = Payload::get("plan/$id");
        return $this->transporter->requestObject($payload)->data();
    }

    public function update(string $id, array $params = []): array|string
    {
        $payload = Payload::put("plan/$id", $params);
        return $this->transporter->requestObject($payload)->data();
    }
}
