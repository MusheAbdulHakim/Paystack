<?php

namespace MusheAbdulHakim\Paystack\Api;

use MusheAbdulHakim\Paystack\Api\Concerns\Transportable;
use MusheAbdulHakim\Paystack\Contracts\Api\TransactionContract;
use MusheAbdulHakim\Paystack\ValueObjects\Transporter\Payload;

final class Transaction implements TransactionContract
{
    use Transportable;

    public function initialize(array $params = []): array|string
    {
        $payload = Payload::post('transaction/initialize', $params);

        return $this->transporter->requestObject($payload)->data();
    }

    public function verify(string $reference): array|string
    {
        $payload = Payload::get("transaction/verify/$reference");

        return $this->transporter->requestObject($payload)->data();
    }

    public function list(array $params = []): array|string
    {
        $payload = Payload::get('transaction', $params);

        return $this->transporter->requestObject($payload)->data();
    }

    public function fetch(int $id): array|string
    {
        $payload = Payload::get("transaction/$id");

        return $this->transporter->requestObject($payload)->data();
    }

    public function chargeAuth(array $params = []): array|string
    {
        $payload = Payload::post('transaction/charge_authorization', $params);

        return $this->transporter->requestObject($payload)->data();
    }

    public function view(string $id): array|string
    {
        $payload = Payload::get("transaction/timeline/$id");

        return $this->transporter->requestObject($payload)->data();
    }

    public function totals(array $params = []): array|string
    {
        $payload = Payload::get('transaction/totals', $params);

        return $this->transporter->requestObject($payload)->data();
    }

    public function export(array $params = []): array|string
    {
        $payload = Payload::get('transaction/export', $params);

        return $this->transporter->requestObject($payload)->data();
    }

    public function partialDebit(array $params = []): array|string
    {
        $payload = Payload::post('transaction/partial_debit', $params);

        return $this->transporter->requestObject($payload)->data();
    }
}
