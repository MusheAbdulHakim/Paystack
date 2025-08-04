<?php

declare(strict_types=1);

namespace MusheAbdulHakim\Paystack\Api;

use MusheAbdulHakim\Paystack\Api\Concerns\Transportable;
use MusheAbdulHakim\Paystack\Contracts\Api\ProductContract;
use MusheAbdulHakim\Paystack\ValueObjects\Transporter\Payload;

final class Product implements ProductContract
{
    use Transportable;

    public function create(array $params = []): array|string
    {
        $payload = Payload::post('product', $params);

        return $this->transporter->requestObject($payload)->data();
    }

    public function list(array $params = []): array|string
    {
        $payload = Payload::get('product', $params);

        return $this->transporter->requestObject($payload)->data();
    }

    public function fetch(string $id): array|string
    {
        $payload = Payload::get("product/$id");

        return $this->transporter->requestObject($payload)->data();
    }

    public function update(string $id, array $params = []): array|string
    {

        $payload = Payload::put("product/$id", $params);

        return $this->transporter->requestObject($payload)->data();
    }
}
