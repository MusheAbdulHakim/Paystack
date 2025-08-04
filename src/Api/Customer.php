<?php

namespace MusheAbdulHakim\Paystack\Api;

use MusheAbdulHakim\Paystack\Api\Concerns\Transportable;
use MusheAbdulHakim\Paystack\Contracts\Api\CustomerContract;
use MusheAbdulHakim\Paystack\ValueObjects\Transporter\Payload;

final class Customer implements CustomerContract
{
    use Transportable;

    public function create(array $params = []): array|string
    {
        $payload = Payload::post('customer', $params);

        return $this->transporter->requestObject($payload)->data();
    }

    public function list(array $params = []): array|string
    {
        $payload = Payload::get('customer');

        return $this->transporter->requestObject($payload)->data();
    }

    public function fetch(string $emailOrCode): array|string
    {
        $payload = Payload::get("customer/$emailOrCode");

        return $this->transporter->requestObject($payload)->data();
    }

    public function update(string $code, array $params = []): array|string
    {
        $payload = Payload::put("customer/$code", $params);

        return $this->transporter->requestObject($payload)->data();
    }

    public function validate(string $code, array $params = []): array|string
    {
        $payload = Payload::post("customer/$code/identification", $params);

        return $this->transporter->requestObject($payload)->data();
    }

    public function status(string $customer, string $action): array|string
    {
        $params['customer'] = $customer;
        $params['risk_action'] = $action;
        $payload = Payload::post('customer/set_risk_action', $params);

        return $this->transporter->requestObject($payload)->data();
    }

    public function blackList(string $customer): array|string
    {
        $params['customer'] = $customer;
        $params['risk_action'] = 'deny';
        $payload = Payload::post('customer/set_risk_action', $params);

        return $this->transporter->requestObject($payload)->data();
    }

    public function whiteList(string $customer): array|string
    {
        $params['customer'] = $customer;
        $params['risk_action'] = 'allow';
        $payload = Payload::post('customer/set_risk_action', $params);

        return $this->transporter->requestObject($payload)->data();
    }

    public function deactivate(string $code): array|string
    {
        $params['authorization_code'] = $code;
        $payload = Payload::post('customer/deactivate_authorization', $params);

        return $this->transporter->requestObject($payload)->data();
    }
}
