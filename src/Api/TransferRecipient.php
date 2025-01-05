<?php

declare(strict_types=1);

namespace MusheAbdulHakim\Paystack\Api;

use MusheAbdulHakim\Paystack\Api\Concerns\Transportable;
use MusheAbdulHakim\Paystack\ValueObjects\Transporter\Payload;
use MusheAbdulHakim\Paystack\Contracts\Api\TransferRecipientContract;

final class TransferRecipient implements TransferRecipientContract
{
    use Transportable;

    public function create(array $params = []): array|string
    {
        $payload = Payload::post("transferrecipient", $params);
        return $this->transporter->requestObject($payload)->data();
    }

    public function bulk(array $batch = []): array|string
    {
        $params['batch'] = $batch;
        $payload = Payload::post("transferrecipient/bulk", $params);
        return $this->transporter->requestObject($payload)->data();
    }

    public function list(array $params = []): array|string
    {
        $payload = Payload::get("transferrecipient", $params);
        return $this->transporter->requestObject($payload)->data();
    }
    public function fetch(string $id): array|string
    {
        $payload = Payload::get("transferrecipient/$id");
        return $this->transporter->requestObject($payload)->data();
    }
    public function update(string $id, array $params = []): array|string
    {
        $payload = Payload::put("transferrecipient/$id", $params);
        return $this->transporter->requestObject($payload)->data();
    }

    public function delete(string $id): array|string
    {
        $payload = Payload::delete("transferrecipient", $id);
        return $this->transporter->requestObject($payload)->data();
    }

}
