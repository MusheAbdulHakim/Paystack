<?php

declare(strict_types=1);

namespace Musheabdulhakim\Paystack;

use Musheabdulhakim\Paystack\Api\ApplePay;
use Musheabdulhakim\Paystack\Api\Customer;
use Musheabdulhakim\Paystack\Api\SubAccount;
use Musheabdulhakim\Paystack\Api\Transaction;
use Musheabdulhakim\Paystack\Api\VirtualAccount;
use Musheabdulhakim\Paystack\Api\TransactionSplit;
use Musheabdulhakim\Paystack\Api\Transfer;
use Musheabdulhakim\Paystack\Api\TransferRecipient;

class Paystack
{
    private $config;

    private $client;

    /**
     * Paystac api base url. default is https://api.paystack.co
     *
     * @var string
     */
    private string $BASE_URL;

    /**
     * Paystack api secret key
     *
     * @var string
     */
    private string $SECRET_KEY;

    /**
     * Paystack api public key
     *
     * @var string
     */
    private string $PUBLIC_KEY;

    /**
     * Paystack merchant email
     *
     * @var string
     */
    private $MERCHANT_EMAIL;

    /**
     * Setup Options for paystack.
     * [
     *  'secret_key' => 'your paystack secret key',
     *  'public_key' => 'your paystack public key',
     *  'base_url' => 'paystack base api url' default(https://api.paystack.co)
     * ]
     *
     * @param array $options
     */
    public function __construct($options = [], $loadEnv = true)
    {
        $this->config = new Config();

        if($loadEnv) {
            $dotenv = \Dotenv\Dotenv::createMutable(__DIR__ .'/..');
            $dotenv->safeLoad();
            if(!empty($_ENV['SECRET_KEY'])) {
                $this->SECRET_KEY = $_ENV['SECRET_KEY'];
                $this->config->set('secret_key', $_ENV['SECRET_KEY']);
            }
            if(!empty($_ENV['PUBLIC_KEY'])) {
                $this->PUBLIC_KEY = $_ENV['PUBLIC_KEY'];
                $this->config->set('public_key', $_ENV['PUBLIC_KEY']);
            }
            if(!empty($_ENV['MERCHANT_EMAIL'])) {
                $this->MERCHANT_EMAIL = $_ENV['MERCHANT_EMAIL'];
                $this->config->set('merchant_email', $_ENV['MERCHANT_EMAIL']);
            }
        }

        $this->BASE_URL = $this->config->get('base_url');
        $this->MERCHANT_EMAIL = $this->config->get('merchant_email');
        $this->SECRET_KEY = $this->config->get('secret_key');
        $this->PUBLIC_KEY = $this->config->get('public_key');

        if (!empty($options) && (count($options) > 0)) {
            if (!empty($options['secret_key']) || !empty($options['SECRET_KEY'])) {
                $this->SECRET_KEY = $options['secret_key'] ?? $options['SECRET_KEY'];
                $this->config->set('secret_key', ($this->SECRET_KEY ?? $options['SECRET_KEY']));
            }
            if (!empty($options['public_key']) || !empty($options['PUBLIC_KEY'])) {
                $this->PUBLIC_KEY = $options['public_key'] ?? $options['PUBLIC_KEY'];
                $this->config->set('public_key', ($this->PUBLIC_KEY ?? $options['PUBLIC_KEY']));
            }
            if (!empty($options['base_url']) || !empty($options['BASE_URL'])) {
                $this->BASE_URL = $options['base_url'] ?? $options['BASE_URL'];
                $this->config->set('base_url', ($this->BASE_URL ?? $options['BASE_URL']));
            }
            if (!empty($options['merchant_email']) || !empty($options['MERCHANT_EMAIL'])) {
                $this->MERCHANT_EMAIL = $options['merchant_email'] ?? $options['MERCHANT_EMAIL'];
                $this->config->set('merchant_email', ($this->MERCHANT_EMAIL?? $options['MERCHANT_EMAIL']));
            }
        }

        $this->client = $this->client();
    }

    /**
     * Set or Get paystack base api url. default (https://api.paystack.co)
     *
     * @param string|null $url
     * @return boolean|string
     */
    public function baseUrl(string $url = null)
    {
        if (!empty($url)) {
            $this->BASE_URL = $url;
            $this->config->set('base_url', $this->BASE_URL);
            return true;
        } else {
            return $this->BASE_URL;
        }
    }

    /**
     * Get or set paystack api secret key
     *
     * @param string|null $key
     * @return boolean|string
     */
    public function secretKey(string $key = null)
    {
        if (!empty($key)) {
            $this->SECRET_KEY = $key;
            $this->config->set('secret_key', $this->SECRET_KEY);
            return true;
        } else {
            return $this->SECRET_KEY;
        }
    }

    /**
     * Set or Get paystack merchant email.
     *
     * @param string|null $email
     * @return boolean|string
     */
    public function merchantEmail(string $email = null)
    {
        if (!empty($email)) {
            $this->MERCHANT_EMAIL = $email;
            $this->config->set('merchant_email', $this->MERCHANT_EMAIL);
            return true;
        } else {
            return $this->MERCHANT_EMAIL;
        }
    }


    /**
     * Set or Get paystack api public key
     *
     * @param string|null $key
     * @return boolean|string
     */
    public function publicKey(string $key = null)
    {
        if (!empty($key)) {
            $this->PUBLIC_KEY = $key;
            $this->config->set('public_key', $this->PUBLIC_KEY);
            return true;
        } else {
            return $this->PUBLIC_KEY;
        }
    }


    /**
     * Http Client
     *
     * @return Client
     */
    private function client()
    {
        $secret = $this->SECRET_KEY;
        $url = $this->BASE_URL;
        $client = $this->config->get('client');
        $this->client = (new $client($secret, $url));
        return $this->client;
    }


    /**
     * Get Config Items
     *
     * @return mixed
     */
    public function getConfig(): mixed
    {
        $this->config->set('secret_key', $this->SECRET_KEY);
        $this->config->set('public_key', $this->PUBLIC_KEY);
        $this->config->set('base_url', $this->BASE_URL);
        $this->config->set('merchant_email', $this->MERCHANT_EMAIL);
        return $this->config;
    }


    /**
     * Gets a list of Countries that Paystack currently supports
     *
     * @return array
     */
    public function countries(): array
    {
        return $this->client->get('country');
    }

    /**
     * The country code of the states to list. It is gotten after the charge request.
     *
     * @param string $iso_2
     * @return array
     */
    public function states(string $iso_2): array
    {
        return $this->client->get('address_verification/states', [
            'country' => strtoupper($iso_2)
        ]);
    }

    /**
     * Get a list of all supported banks and their properties
     *
     * @param string $country
     * The country from which to obtain the list of supported banks. e.g country=ghana or country=nigeria
     *
     * @param array $params
     * @return array
     */
    public function banks(string $country = null, $params = []): array
    {
        $params['country'] = $country;
        return $this->client->get('bank', $params);
    }


    /**
     * Initialize Transaction
     * @link https://paystack.com/docs/api/#transaction-initialize
     *
     * @param string|null $email
     * @param string $amount
     * @param array $params
     * @return mixed|\Musheabdulhakim\Paystack\Transaction::class
     */
    public function transaction(string $email = null, $amount = null, $params = [])
    {
        if (!empty($email) && !empty($amount)) {
            return (new Transaction($this->client))->init($email, $amount, $params);
        } else {
            return (new Transaction($this->client));
        }
    }

    /**
     * List transactions carried out on your integration.
     *
     * @link https://paystack.com/docs/api/#transaction-list
     *
     * @param array $params
     * @return array|string
     */
    public function transactions($params = [])
    {
        return (new Transaction($this->client))->list($params);
    }

    /**
     * Initialize or Create a split payment on your integration
     *
     * @param array $params
     * @return array|\TransactionSplit::class
     */
    public function transactionSplit($params = [])
    {
        if (!empty($params) && (count($params) > 0)) {
            $name = $params['name'];
            $type = $params['type'];
            $currency = $params['currency'];
            $subaccounts = $params['subaccounts'];
            $bearer_type = $params['bearer_type'];
            $bearer_subaccount = $params['bearer_subaccount'];
            return (new TransactionSplit($this->client))->create($name, $type, $currency, $bearer_type, $bearer_subaccount, $subaccounts);
        } else {
            return (new TransactionSplit($this->client));
        }
    }


   /**
    * Create a customer or initialize the customer class
    *
    * @param array|null $params
    * @return array|Customer
    */
    public function customer(?array $params = []): array|Customer
    {
        if (!empty($params) && (count($params) > 0)) {
            $first_name = $params['first_name'];
            $last_name = $params['last_name'];
            $email = $params['email'];
            $phone = $params['phone'];
            $metadata = $params['metadata'] ?? null;
            return (new Customer($this->client))->create($first_name, $last_name, $email, $phone, $metadata);
        } else {
            return (new Customer($this->client));
        }
    }

    /**
     * Initialize the VirtualAccount Class
     *
     * @return VirtualAccount
     */
    public function virtualAccount(): VirtualAccount
    {
        return (new VirtualAccount($this->client));
    }

    /**
     * Initialize ApplePay class. Pass domainName to register a top-level domain.
     *
     * @param string|null $domainName
     * @return array|\Musheabdulhakim\Paystack\Api\ApplePay
     */
    public function applePay(string $domainName = null): array|ApplePay
    {
        return !empty($domainName) ? (new ApplePay($this->client))->register($domainName) : (new ApplePay($this->client));
    }

    /**
     * Initialize SubAccount class. You can also pass the parameters to create subaccount on init
     *
     * @param array $params
     * @return array|\Musheabdulhakim\Paystack\Api\SubAccount
     */
    public function subAccount($params = []): array|SubAccount
    {
        if (!empty($params) && (count($params) > 0)) {
            $business_name = $params['business_name'] ?? null;
            $settlement_bank = $params['settlement_bank'] ?? null;
            $account_number = $params['account_number'] ?? null;
            $percentage_charge = $params['percentage_charge'] ?? null;
            $description = $params['description'] ?? null;
            return (new SubAccount($this->client))->create($business_name, $settlement_bank, $account_number, $percentage_charge, $description);
        } else {
            return (new SubAccount($this->client));
        }
    }

    /**
     * Intialize TransferRecipient Class or pass the parameters to create transfer recipient.
     *
     * @param array $params
     * @return array|TransferRecipient
     */
    public function transferRecipient($params = []): array|TransferRecipient
    {
        if(!empty($params) && count($params) > 0){
            $type = $params['type'] ?? null;
            $name = $params['name'] ?? null;
            $account_number = $params['account_number'] ?? null;
            $bank_code = $params['bank_code'] ?? null;
            $currency = $params['currency'] ?? null;
            return (new TransferRecipient($this->client))->create($type, $name,$account_number, $bank_code, $currency);
        }
        return (new TransferRecipient($this->client));
    }

    /**
     * Intialize Transfer Class or quickly initialize transfer by passing the parameters.
     *
     * @param integer|null $amount
     * @param string|null $recipient
     * @param string|null $currency
     * @return array|Transfer
     */
    public function transfer(int $amount = null, string $recipient = null, string $currency = null): array|Transfer
    {
        if(!empty($amount) && !empty($recipient)){
            return (new Transfer($this->client))->init($amount,$recipient, $currency);
        }else{
            return (new Transfer($this->client));
        }
    }
}
