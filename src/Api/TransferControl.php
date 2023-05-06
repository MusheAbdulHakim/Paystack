<?php
declare(strict_types=1);
namespace Musheabdulhakim\Paystack\Api;

use Musheabdulhakim\Paystack\Contracts\PaystackClientInterface;

/**
 * The Transfers Control API allows you manage settings of your transfers.
 * @link https://paystack.com/docs/api/transfer-control#transfers-control
 */
class TransferControl
{
    private $client;

    public function __construct(PaystackClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * Fetch the available balance on your integration
     *
     * @return array
     * @link https://paystack.com/docs/api/transfer-control#balance
     */
    public function balance(): array
    {
        return $this->client->get('balance');
    }


    /**
     * Fetch all pay-ins and pay-outs that occured on your integration
     *
     * @return array
     * @link https://paystack.com/docs/api/transfer-control#balance-ledger
     */
    public function ledger(): array
    {
        return $this->client->get('balance/ledger');
    }

    /**
     * Generates a new OTP and sends to customer in the event they are having trouble receiving one.
     *
     * @param string $transfer_code Transfer code
     * @param string $reason Either resend_otp or transfer
     * @return array
     * @link https://paystack.com/docs/api/transfer-control#resend-otp
     */
    public function sendOtp(string $transfer_code, string $reason): array
    {
        $params['reason'] = $reason;
        $params['transfer_code'] = $transfer_code;
        return $this->client->post('/transfer/resend_otp',$params);
    }

    /**
     * This is used in the event that you want to be able to complete transfers programmatically without use of OTPs. No arguments required. You will get an OTP to complete the request.
     *
     * @return array
     * @link https://paystack.com/docs/api/transfer-control#disable-otp
     */
    public function disableOtp(): array
    {
        return $this->client->post('transfer/disable_otp');
    }

    /**
     * Finalize the request to disable OTP on your transfers.
     *
     * @param string $otp OTP sent to business phone to verify disabling OTP requirement
     * @return array
     * @link https://paystack.com/docs/api/transfer-control#finalize-disable-otp
     */
    public function finalizeOtp(string $otp): array
    {
        $params['otp'] = $otp;
        return $this->client->post('transfer/disable_otp_finalize', $params);
    }

    /**
     * In the event that a customer wants to stop being able to complete transfers programmatically, this endpoint helps turn OTP requirement back on. No arguments required.
     *
     * @return array
     * @link https://paystack.com/docs/api/transfer-control#enable-otp
     */
    public function enableOtp(): array
    {
        return $this->client->post('transfer/enable_otp');
    }

}
