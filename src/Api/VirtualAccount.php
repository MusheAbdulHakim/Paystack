<?php

namespace MusheAbdulHakim\Paystack\Api;

use MusheAbdulHakim\Paystack\Api\Concerns\Transportable;
use MusheAbdulHakim\Paystack\ValueObjects\Transporter\Payload;
use MusheAbdulHakim\Paystack\Contracts\Api\VirtualAccountContract;

final class VirtualAccount implements VirtualAccountContract
{
    use Transportable;

    public function create(array $params = []): array|string
    {
        $payload = Payload::post("dedicated_account", $params);
        return $this->transporter->requestObject($payload)->data();
    }

    public function assign(array $params = []): array|string
    {
        $payload = Payload::post("dedicated_account/assign", $params);
        return $this->transporter->requestObject($payload)->data();
    }

    public function list(array $params = []): array|string
    {
        $payload = Payload::get("dedicated_account", $params);
        return $this->transporter->requestObject($payload)->data();
    }

    public function fetch(string $id): array|string
    {
        $payload = Payload::get("dedicated_account/$id");
        return $this->transporter->requestObject($payload)->data();
    }

    public function requery(array $params = []): array|string
    {
        $payload = Payload::get("dedicated_account/requery", $params);
        return $this->transporter->requestObject($payload)->data();
    }

    public function deactivate(string $id): array|string
    {
        $payload = Payload::deleteFromUri("dedicated_account/$id");
        return $this->transporter->requestObject($payload)->data();
    }

    public function splitTransaction(string $customer, array $params = []): array|string
    {
        $params['customer'] = $customer;
        $payload = Payload::post("dedicated_account/split", $params);
        return $this->transporter->requestObject($payload)->data();
    }

    public function removeSplit(string $account): array|string
    {
        $params = [
            'account_number' => $account
        ];
        $payload = Payload::custom(
            \MusheAbdulHakim\Paystack\Enums\Transporter\Method::DELETE,
            \MusheAbdulHakim\Paystack\Enums\Transporter\ContentType::JSON,
            "dedicated_account/split",
            $params
        );
        return $this->transporter->requestObject($payload)->data();
    }

    public function bankProviders(): array|string
    {
        $payload = Payload::get("dedicated_account/available_providers");
        return $this->transporter->requestObject($payload)->data();
    }
}
