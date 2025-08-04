<?php

declare(strict_types=1);

namespace MusheAbdulHakim\Paystack\Contracts\Api;

interface TransferContract
{
    /**
     * Initiate Transfer
     *
     * @param  array<mixed>  $params
     * @return array<mixed>|string
     */
    public function init(array $params = []): array|string;

    /**
     * Finalize Transfer
     *
     * @param  string  $code  The transfer code you want to finalize
     * @param  string  $otp  OTP sent to business phone to verify transfer
     * @return array<mixed>|string
     */
    public function finalize(string $code, string $otp): array|string;

    /**
     * Initiate Bulk Transfer
     *
     * @param  array<string>  $transfers
     * @return array<mixed>|string
     */
    public function bulk(string $source, array $transfers = []): array|string;

    /**
     * List Transfers
     *
     * @param  array<mixed>  $params
     * @return array<mixed>|string
     */
    public function list(array $params = []): array|string;

    /**
     * Fetch Transfer
     *
     * @return array<mixed>|string
     */
    public function fetch(string $id): array|string;

    /**
     * Verify Transfer
     *
     * @return array<mixed>|string
     */
    public function verify(string $reference): array|string;
}
