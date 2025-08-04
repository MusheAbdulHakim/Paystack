<?php

namespace MusheAbdulHakim\Paystack\Api;

use MusheAbdulHakim\Paystack\Api\Concerns\Transportable;
use MusheAbdulHakim\Paystack\Contracts\Api\ApplePayContract;
use MusheAbdulHakim\Paystack\ValueObjects\Transporter\Payload;

final class ApplePay implements ApplePayContract
{
    use Transportable;

    public function register(string $domain): array|string
    {
        $params['domainName'] = $domain;
        $payload = Payload::post('apple-pay/domain', $params);

        return $this->transporter->requestObject($payload)->data();
    }

    public function list(array $params = []): array|string
    {
        $payload = Payload::get('apple-pay/domain', $params);

        return $this->transporter->requestObject($payload)->data();
    }

    public function unregister(string $domain): array|string
    {
        $params['domainName'] = $domain;
        $payload = Payload::custom(
            \MusheAbdulHakim\Paystack\Enums\Transporter\Method::DELETE,
            \MusheAbdulHakim\Paystack\Enums\Transporter\ContentType::JSON,
            'apple-pay/domain',
            $params
        );

        return $this->transporter->requestObject($payload)->data();
    }
}
