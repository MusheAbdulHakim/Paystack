<?php
declare(strict_types=1);

namespace Musheabdulhakim\Paystack\Api;

use Musheabdulhakim\Paystack\Contracts\PaystackClientInterface;

/**
 * The Charge Class allows you to configure payment channel of your choice when initiating a payment.
 * @link https://paystack.com/docs/api/charge#charges
 */
class Charge
{
    private $client;

    public function __construct(PaystackClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * Initiate a payment by integrating the payment channel of your choice (@link https://paystack.com/docs/payments/payment-channels).
     *
     * @param string $email https://paystack.com/docs/payments/payment-channels
     * @param string $amount Amount should be in kobo if currency is NGN, pesewas, if currency is GHS, and cents, if currency is ZAR
     * @param array $params Optional parameters. Refer to the docs.
     * @return array
     * @link https://paystack.com/docs/api/charge#create
     */
    public function create(string $email, string $amount, $params = []): array
    {
        $params['email'] = $email;
        $params['amount'] = $amount;
       return $this->client->post("charge", $params);
    }

    /**
     * Submit PIN to continue a charge
     *
     * @param string $pin PIN submitted by user
     * @param string $reference Reference for transaction that requested pin
     * @return array
     * @link https://paystack.com/docs/api/charge#submit-pin
     */
    public function pin(string $pin, string $reference): array
    {
        $params['pin'] = $pin;
        $params['reference'] = $reference;
        return $this->client->post("charge/submit_pin", $params);
    }

    /**
     * Submit OTP to complete a charge
     *
     * @param string $otp OTP submitted by user
     * @param string $reference Reference for ongoing transaction
     * @return array
     * @link https://paystack.com/docs/api/charge#submit-otp
     */
    public function otp(string $otp, string $reference): array
    {
        $params['otp'] = $otp;
        $params['reference'] = $reference;
        return $this->client->post("charge/submit_otp", $params);
    }

    /**
     * Submit phone number when requested
     *
     * @param string $phone Phone submitted by user
     * @param string $reference Reference for ongoing transaction
     * @return array
     * @link https://paystack.com/docs/api/charge#submit-phone
     */
    public function phone(string $phone, string $reference): array
    {
        $params['phone'] = $phone;
        $params['reference'] = $reference;
        return $this->client->post("charge/submit_phone", $params);
    }

    /**
     * Submit Birthday when requested
     *
     * @param string $birthday Birthday submitted by user e.g. 2016-09-21
     * @param string $reference Reference for ongoing transaction
     * @return array
     * @link https://paystack.com/docs/api/charge#submit-birthday
     */
    public function birthday(string $birthday, string $reference): array
    {
        $params['birthday'] = $birthday;
        $params['reference'] = $reference;
        return $this->client->post("", $params);
    }

    /**
     * Submit address to continue a charge
     *
     * @param string $address Address submitted by user
     * @param string $reference Reference for ongoing transaction
     * @param string $city City submitted by user
     * @param string $state State submitted by user
     * @param string $zipcode Zipcode submitted by user
     * @return array
     * @link https://paystack.com/docs/api/charge#submit-address
     */
    public function address(string $address, string $reference, string $city, string $state, string $zipcode): array
    {
        $params['address'] = $address;
        $params['reference'] = $reference;
        $params['city'] = $city;
        $params['state'] = $state;
        $params['zipcode'] = $zipcode;
        return $this->client->post("charge/submit_address", $params);
    }

    /**
     * When you get pending as a charge status or if there was an exception when calling any of the /charge endpoints, wait 10 seconds or more, then make a check to see if its status has changed. Don't call too early as you may get a lot more pending than you should.
     *
     * @param string $reference The reference to check
     * @return array
     * @link https://paystack.com/docs/api/charge#check
     */
    public function checkPending(string $reference): array
    {
        return $this->client->get("charge/{$reference}");
    }
}
