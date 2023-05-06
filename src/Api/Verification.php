<?php

declare(strict_types=1);

namespace Musheabdulhakim\Paystack\Api;

use Musheabdulhakim\Paystack\Contracts\PaystackClientInterface;

/**
 * The Verification Classs allows you perform KYC processes.
 * @link https://paystack.com/docs/api/verification#verification
 */
class Verification
{
    private $client;

    public function __construct(PaystackClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * Confirm an account belongs to the right customer
     *
     * @param string $account_number Account Number
     * @param string $bank_code You can get the list of bank codes by calling the List Banks endpoint @link https://paystack.com/docs/api/miscellaneous#bank
     * @return array
     */
    public function resolve(string $account_number, string $bank_code): array
    {
        $params['account_number'] = $account_number;
        $params['bank_code'] = $bank_code;
        return $this->client->get("bank/resolve", $params);
    }

    /**
     * Confirm the authenticity of a customer's account number before sending money
     *
     * @param string $account_name Customer's first and last name registered with their bank
     * @param string $account_number Customer’s account number
     * @param string $account_type This can take one of: [ personal, business ]
     * @param string $bank_code The bank code of the customer’s bank. You can fetch the bank codes by using our List Banks endpoint @https://paystack.com/docs/api/miscellaneous#bank
     * @param string $country_code The two digit ISO code of the customer’s bank
     * @param string $document_type Customer’s mode of identity. This could be one of: [ identityNumber, passportNumber, businessRegistrationNumber ]
     * @param array $params Optional parameters. Refer to the docs
     * @return array
     * @link https://paystack.com/docs/api/verification#validate-account
     */
    public function validate(string $account_name, string $account_number, string $account_type, string $bank_code, string $country_code, string $document_type, $params = []): array
    {
        $params['account_name'] =  $account_name;
        $params['account_number'] =  $account_number;
        $params['account_type'] =  $account_type;
        $params['bank_code'] =  $bank_code;
        $params['country_code'] =  $country_code;
        $params['document_type'] =  $document_type;
        return $this->client->post('bank/validate', $params);
    }

    /**
     * Get more information about a customer's card
     *
     * @param string $bin First 6 characters of card
     * @return array
     * @link https://paystack.com/docs/api/verification#resolve-card
     */
    public function bin(string $bin): array
    {
        return $this->client->get("T/decision/bin/{$bin}");
    }
}
