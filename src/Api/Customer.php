<?php

declare(strict_types=1);

namespace Musheabdulhakim\Paystack\Api;

use Musheabdulhakim\Paystack\Contracts\PaystackClientInterface;

class Customer
{
    private $client;

    public function __construct(PaystackClientInterface $client)
    {
        $this->client = $client;
    }


    /**
     * Create a customer on your integration
     *
     * @param string $first_name Customer's first name
     * @param string $last_name Customer's last name
     * @param string $email Customer's email address
     * @param string|null $phone Customer's phone
     * @param array|null $metadata A set of key/value pairs that you can attach to the customer. It can be used to store additional information in a structured format.
     * @return array
     * @link https://paystack.com/docs/api/customer#create
     */
    public function create(string $first_name, string $last_name, string $email, ?string $phone = null, ?array $metadata = []): array
    {
        $params['first_name'] = $first_name;
        $params['last_name'] = $last_name;
        $params['email'] = $email;
        $params['phone'] = $phone;
        $params['metadata'] = $metadata;
        return $this->client->post("customer", $params);
    }

    /**
     * List customers available on your integration.
     *
     * @param array|null $params
     * @return array Query Parameters
     * @link https://paystack.com/docs/api/customer#list
     */
    public function list(?array $params = []): array
    {
        return $this->client->get('customer', $params);
    }

    /**
     * Get details of a customer on your integration.
     *
     * @param string $email_or_code An email or customer code for the customer you want to fetch
     * @return array
     * @link https://paystack.com/docs/api/customer#fetch
     */
    public function fetch(string $email_or_code): array{
        return $this->client->get("customer/{$email_or_code}");
    }

    /**
     * Get details of a customer on your integration.
     *
     * @param string $email_or_code An email or customer code for the customer you want to fetch
     * @return array
     * @link https://paystack.com/docs/api/customer#fetch
     */
    public function get(string $email_or_code): array{
        return $this->client->get("customer/{$email_or_code}");
    }

    public function update(string $code, ?string $first_name = null, ?string $last_name = null, ?array $params = []): array
    {
        $url = "customer/{$code}";
        if(empty($params)){
            if(!empty($first_name)){
                $params['first_name'] = $first_name;
            }
            if(!empty($last_name)){
                $params['last_name'] = $last_name;
            }
        }
        return $this->client->put($url, $params);
    }

    /**
     * Validate a customer's identity
     *
     * @param string $code Email, or customer code of customer to be identified
     * @param string|array $first_name Customer's first name. Or an array of the customer details.
     * @param string|null $last_name Customer's last name
     * @param string|null $type Predefined types of identification. Only bank_account is supported at the moment
     * @param string|null $value Customer's identification number
     * @param string|null $country 2 letter country code of identification issuer
     * @param string|null $bvn Customer's Bank Verification Number
     * @param string|null $bank_code You can get the list of Bank Codes by calling the List Banks endpoint. (required if type is bank_account)
     * @param string|null $account_number Customer's bank account number. (required if type is bank_account)
     * @return array
     * @link https://paystack.com/docs/api/customer#validate
     */
    public function validate(string $code, string|array $first_name = null,string $middle_name = null, string $last_name = null, string $type = null, string $value = null, string $country = null,
    string $bvn = null, string $bank_code = null, string $account_number=null): array
    {
        if(!is_array($first_name)){
            $params['first_name'] = $first_name;
            $params['middle_name'] = $middle_name;
            $params['last_name'] = $last_name;
            $params['type'] = $type;
            $params['value'] = $value;
            $params['country'] = $country;
            $params['bvn'] = $bvn;
            $params['bank_code'] = $bank_code;
            $params['account_number'] = $account_number;
        }else{
            $params = $first_name;
        }
        return $this->client->post("customer/{$code}/identification", $params);
    }

    /**
     * Whitelist or blacklist a customer on your integration
     *
     * @param string $customer Customer's code, or email address
     * @param string $risk_action One of the possible risk actions [ default, allow, deny ]. allow to whitelist. deny to blacklist. Customers start with a default risk action.
     * @return array
     */
    public function setRiskAction(string $customer, string $risk_action = "default"): array
    {
        $params['authorization_code'] = $customer;
        $params['risk_action'] = $risk_action;
        return $this->client->post("customer/deactivate_authorization", $params);
    }

    /**
     * Deactivate an authorization when the card needs to be forgotten
     *
     * @param string $authorization_code Authorization code to be deactivated
     * @return array
     */
    public function deactivateAuth(string $authorization_code): array{
        $params['authorization_code'] = $authorization_code;
        return $this->client->post("customer/deactivate_authorization", $params);
    }
}
