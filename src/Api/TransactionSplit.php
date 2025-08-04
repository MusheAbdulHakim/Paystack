<?php

namespace MusheAbdulHakim\Paystack\Api;

use MusheAbdulHakim\Paystack\Api\Concerns\Transportable;
use MusheAbdulHakim\Paystack\Contracts\Api\TransactionSplitContract;
use MusheAbdulHakim\Paystack\ValueObjects\Transporter\Payload;

final class TransactionSplit implements TransactionSplitContract
{
    use Transportable;

    public function create(array $params = []): array|string
    {
        $payload = Payload::post('split', $params);

        return $this->transporter->requestObject($payload)->data();
    }

    public function list(array $params = []): array|string
    {
        $payload = Payload::get('split', $params);

        return $this->transporter->requestObject($payload)->data();
    }

    public function fetch(string $reference): array|string
    {
        $payload = Payload::get("split/$reference");

        return $this->transporter->requestObject($payload)->data();
    }

    public function update(string $id, array $params = []): array|string
    {
        $payload = Payload::put("split/$id", $params);

        return $this->transporter->requestObject($payload)->data();
    }

    public function addSubAccount(string $id, array $params = []): array|string
    {
        $payload = Payload::post("split/$id/subaccount/add", $params);

        return $this->transporter->requestObject($payload)->data();
    }

    public function removeSubAccount(string $id, array $params = []): array|string
    {
        $payload = Payload::post("split/$id/subaccount/remove", $params);

        return $this->transporter->requestObject($payload)->data();
    }
}
