<?php

declare(strict_types=1);

namespace MusheAbdulHakim\Paystack\Api;

use MusheAbdulHakim\Paystack\Api\Concerns\Transportable;
use MusheAbdulHakim\Paystack\ValueObjects\Transporter\Payload;
use MusheAbdulHakim\Paystack\Contracts\Api\IntegrationContract;

final class Integration implements IntegrationContract
{
    use Transportable;

    public function fetchPayment(): array|string
    {
        $payload = Payload::get("integration/payment_session_timeout");
        return $this->transporter->requestObject($payload)->data();
    }

    public function updatePayment(int $timeout): array|string
    {
        $params['timeout'] = $timeout;
        $payload = Payload::put("integration/payment_session_timeout", $params);
        return $this->transporter->requestObject($payload)->data();
    }
}
