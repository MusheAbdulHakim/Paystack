<?php

declare(strict_types=1);

namespace MusheAbdulHakim\Paystack\Api;

use MusheAbdulHakim\Paystack\Api\Concerns\Transportable;
use MusheAbdulHakim\Paystack\Contracts\Api\SubAccountContract;
use MusheAbdulHakim\Paystack\ValueObjects\Transporter\Payload;

final class SubAccount implements SubAccountContract
{
    use Transportable;

    public function create(array $params = []): array|string
    {
        $payload = Payload::post('subaccount', $params);

        return $this->transporter->requestObject($payload)->data();
    }

    public function list(array $params = []): array|string
    {
        $payload = Payload::get('subaccount', $params);

        return $this->transporter->requestObject($payload)->data();
    }

    public function fetch(string $id): array|string
    {

        $payload = Payload::get("subaccount/$id");

        return $this->transporter->requestObject($payload)->data();
    }

    public function update(string $id, array $params = []): array|string
    {
        $payload = Payload::put("subaccount/$id", $params);

        return $this->transporter->requestObject($payload)->data();
    }
}
