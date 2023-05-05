<?php
declare(strict_types=1);

namespace Musheabdulhakim\Paystack\Api;

use Musheabdulhakim\Paystack\Contracts\PaystackClientInterface;

/**
 * The Transfers API allows you automate sending money to your customers.
 * @link https://paystack.com/docs/api/transfer#transfers
 */
class Transfer
{
    private $client;

    public function __construct(PaystackClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * Send money to your customers.
     * Status of transfer object returned will be pending if OTP is disabled. In the event that an OTP is required, status will read otp.
     *
     * @param string $source Where should we transfer from? Only balance for now
     * @param integer $amount Amount to transfer in kobo if currency is NGN and pesewas if currency is GHS.
     * @param string $recipient Code for transfer recipient
     * @param string $currency Specify the currency of the transfer. Defaults to NGN
     * @param array $params Optional parameters. Refer to the docs
     * @return array
     * @link https://paystack.com/docs/api/transfer#initiate
     */
    public function init(string $source = "balance", int $amount, string $recipient, string $currency = "NGN", $params = []): array
    {
        $params['source'] = $source;
        $params['amount'] = $amount;
        $params['recipient'] = $recipient;
        $params['currency'] = $currency;
        return $this->client->post("transfer", $params);

    }

    /**
     * Finalize an initiated transfer
     *
     * @param string $transfer_code The transfer code you want to finalize
     * @param string $otp OTP sent to business phone to verify transfer
     * @return array
     * @link https://paystack.com/docs/api/transfer#finalize
     */
    public function finalize(string $transfer_code, string $otp): array
    {
        $params['transfer_code'] = $transfer_code;
        $params['otp'] = $otp;
        return $this->client->post("transfer/finalize_transfer", $params);
    }

    /**
     * Batch multiple transfers in a single request.
     * You need to disable the Transfers OTP requirement to use this endpoint.
     *
     * @param string $source Where should we transfer from? Only balance for now
     * @param string $currency Specify the currency of the transfer. Defaults to NGN
     * @param array $transfers A list of transfer object. Each object should contain amount, recipient, and reference
     * @return array
     * @link https://paystack.com/docs/api/transfer#bulk
     */
    public function bulk(string $source = "balance", string $currency = "NGN", array $transfers): array
    {
        $params['source'] = $source;
        $params['currency'] = $currency;
        $params['transfers'] = $transfers;
        return $this->client->post("transfer/bulk", $params);
    }

    /**
     * List the transfers made on your integration.
     *
     * @param array $params Query parameters
     * @return array
     * @link https://paystack.com/docs/api/transfer#list
     */
    public function list($params = []): array
    {
        return $this->client->get("transfer", $params);
    }

    /**
     * Get details of a transfer on your integration.
     *
     * @param string $id_or_code The transfer ID or code you want to fetch
     * @return array
     * @link https://paystack.com/docs/api/transfer#fetch
     */
    public function fetch(string $id_or_code): array
    {
        return $this->client->get("transfer/{$id_or_code}");
    }

    /**
     * Verify the status of a transfer on your integration.
     *
     * @param string $reference Transfer reference
     * @return array
     * @link https://paystack.com/docs/api/transfer#verify
     */
    public function verify(string $reference): array
    {
        return $this->client->get("transfer/verify/{$reference}");
    }

}
