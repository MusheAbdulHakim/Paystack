<?php

declare(strict_types=1);

namespace MusheAbdulHakim\Paystack\Api;

use MusheAbdulHakim\Paystack\Api\Concerns\Transportable;
use MusheAbdulHakim\Paystack\Contracts\Api\MiscellaneousContract;
use MusheAbdulHakim\Paystack\ValueObjects\Transporter\Payload;

final class Miscellaneous implements MiscellaneousContract
{
    use Transportable;

    public function banks(array $params = []): array|string
    {
        $payload = Payload::get('bank', $params);

        return $this->transporter->requestObject($payload)->data();
    }

    public function countries(): array|string
    {
        $payload = Payload::get('country');

        return $this->transporter->requestObject($payload)->data();
    }

    public function states(array $params = []): array|string
    {
        $payload = Payload::get('address_verification/states', $params);

        return $this->transporter->requestObject($payload)->data();
    }
}
