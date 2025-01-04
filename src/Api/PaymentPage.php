<?php

declare(strict_types=1);

namespace MusheAbdulHakim\Paystack\Api;

use MusheAbdulHakim\Paystack\Api\Concerns\Transportable;
use MusheAbdulHakim\Paystack\ValueObjects\Transporter\Payload;
use MusheAbdulHakim\Paystack\Contracts\Api\PaymentPageContract;

final class PaymentPage implements PaymentPageContract
{
    use Transportable;

    public function create(string $name, array $params = []): array|string
    {
        $params['name'] = $name;
        $payload = Payload::post("page", $params);
        return $this->transporter->requestObject($payload)->data();
    }

    public function list(array $params = []): array|string
    {
        $payload = Payload::get("page", $params);
        return $this->transporter->requestObject($payload)->data();
    }

    public function fetch(string $id): array|string
    {
        $payload = Payload::get("page/$id");
        return $this->transporter->requestObject($payload)->data();
    }

    public function update(string $id, array $params = []): array|string
    {
        $payload = Payload::put("page/$id", $params);
        return $this->transporter->requestObject($payload)->data();
    }

    public function checkSlug(string $slug): array|string
    {
        $payload = Payload::get("page/check_slug_availability/$slug");
        return $this->transporter->requestObject($payload)->data();
    }

    public function addProduct(string $id, array $products = []): array|string
    {
        $params['product'] = $products;
        $payload = Payload::post("page/$id/product", $params);
        return $this->transporter->requestObject($payload)->data();
    }
}
