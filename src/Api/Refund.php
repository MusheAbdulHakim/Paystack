<?php

declare(strict_types=1);

namespace MusheAbdulHakim\Paystack\Api;

use MusheAbdulHakim\Paystack\Api\Concerns\Transportable;
use MusheAbdulHakim\Paystack\Contracts\Api\RefundContract;
use MusheAbdulHakim\Paystack\ValueObjects\Transporter\Payload;

final class Refund implements RefundContract
{
    use Transportable;


    public function create(string $transaction, array $params = []): array|string
    {
        $params['transaction'] = $transaction;
        $payload = Payload::post("refund", $params);
        return $this->transporter->requestObject($payload)->data();
    }


    public function list(string $transaction, array $params = []): array|string
    {
        $params['transaction'] = $transaction;
        $payload = Payload::get("refund", $params);
        return $this->transporter->requestObject($payload)->data();
    }

    public function fetch(string $id): array|string
    {

        $payload = Payload::get("refund/$id");
        return $this->transporter->requestObject($payload)->data();
    }

}
