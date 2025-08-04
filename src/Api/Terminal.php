<?php

namespace MusheAbdulHakim\Paystack\Api;

use MusheAbdulHakim\Paystack\Api\Concerns\Transportable;
use MusheAbdulHakim\Paystack\Contracts\Api\TerminalContract;
use MusheAbdulHakim\Paystack\ValueObjects\Transporter\Payload;

final class Terminal implements TerminalContract
{
    use Transportable;

    public function sendEvent(string $terminalId, array $params = []): array|string
    {
        $payload = Payload::post("terminal/$terminalId/event", $params);

        return $this->transporter->requestObject($payload)->data();
    }

    public function eventStatus(string $terminalId, string $eventId): array|string
    {
        $payload = Payload::get("terminal/$terminalId/event/$eventId");

        return $this->transporter->requestObject($payload)->data();
    }

    public function status(string $terminalId): array|string
    {
        $payload = Payload::get("terminal/$terminalId/presence");

        return $this->transporter->requestObject($payload)->data();
    }

    public function list(array $params = []): array|string
    {
        $payload = Payload::get('terminal', $params);

        return $this->transporter->requestObject($payload)->data();
    }

    public function fetch(string $terminalId): array|string
    {
        $payload = Payload::get("terminal/$terminalId");

        return $this->transporter->requestObject($payload)->data();
    }

    public function update(string $terminalId, array $params = []): array|string
    {
        $payload = Payload::put("terminal/$terminalId", $params);

        return $this->transporter->requestObject($payload)->data();
    }

    public function commission(array $params = []): array|string
    {
        $payload = Payload::post('terminal/commission_device', $params);

        return $this->transporter->requestObject($payload)->data();
    }

    public function deCommission(array $params = []): array|string
    {
        $payload = Payload::post('terminal/decommission_device', $params);

        return $this->transporter->requestObject($payload)->data();
    }
}
