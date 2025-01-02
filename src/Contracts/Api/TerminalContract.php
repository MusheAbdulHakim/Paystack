<?php

namespace MusheAbdulHakim\Paystack\Contracts\Api;

interface TerminalContract
{
    /**
     * Send Event
     *
     * @param array<mixed> $params
     * @return array<mixed>|string
     */
    public function sendEvent(string $terminalId, array $params = []): array|string;

    /**
     * Fetch Event Status
     *
     * @return array<mixed>|string
     */
    public function eventStatus(string $terminalId, string $eventId): array|string;

    /**
     * Fetch Terminal Status
     *
     * @return array<mixed>|string
     */
    public function status(string $terminalId): array|string;

    /**
     * List Terminals
     * @param array<string> $params
     * @return array<mixed>|string
     */
    public function list(array $params = []): array|string;
    /**
     * Fetch Terminal
     * @return array<mixed>|string
     */
    public function fetch(string $terminalId): array|string;
    /**
     * Update Terminal
     * @param array<mixed> $params
     * @return array<mixed>|string
     */
    public function update(string $terminalId, array $params = []): array|string;

    /**
     * Commission Terminal
     * @param array<mixed> $params
     * @return array<mixed>|string
     */
    public function commission(array $params = []): array|string;

    /**
     * Decommission Terminal
     * @param array<string> $params
     * @return array<mixed>|string
     */
    public function deCommission(array $params = []): array|string;
}
