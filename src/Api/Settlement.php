<?php

declare(strict_types=1);

namespace MusheAbdulHakim\Paystack\Api;

use MusheAbdulHakim\Paystack\Api\Concerns\Transportable;
use MusheAbdulHakim\Paystack\Contracts\Api\SettlementContract;
use MusheAbdulHakim\Paystack\ValueObjects\Transporter\Payload;

final class Settlement implements SettlementContract
{
    use Transportable;

    public function list(array $params = []): array|string
    {
        $payload = Payload::get("settlement", $params);
        return $this->transporter->requestObject($payload)->data();
    }

    public function transactions(string $id, array $params = []): array|string
    {

        $payload = Payload::get("settlement/$id/transactions", $params);
        return $this->transporter->requestObject($payload)->data();
    }
}
