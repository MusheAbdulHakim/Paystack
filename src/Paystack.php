<?php

declare(strict_types=1);

namespace Musheabdulhakim\Paystack;

class Paystack
{
    private $config;

    private $client;

    /**
     * Paystac api base url. default is https://api.paystack.co
     *
     * @var string
     */
    public string $BASE_URL;

    /**
     * Paystack api secret key
     *
     * @var string
     */
    public string $SECRET_KEY;

    /**
     * Paystack api public key
     *
     * @var string
     */
    public string $PUBLIC_KEY;

    /**
     * Paystack merchant email
     *
     * @var string
     */
    public $MERCHANT_EMAIL;

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
    public function __construct($options = [])
    {
        $this->config = new Config();

        $this->BASE_URL = $this->config->get('base_url');
        $this->MERCHANT_EMAIL = $this->config->get('merchant_email');
        $this->SECRET_KEY = $this->config->get('secret_key');
        $this->PUBLIC_KEY = $this->config->get('public_key');

        if (!empty($options) && (count($options) > 0)) {
            if (!empty($options['secret_key'])) {
                $this->SECRET_KEY = $options['secret_key'];
                $this->config->set('secret_key', $this->SECRET_KEY);
            }
            if (!empty($options['public_key'])) {
                $this->PUBLIC_KEY = $options['public_key'];
                $this->config->set('public_key', $this->PUBLIC_KEY);
            }
            if (!empty($options['base_url'])) {
                $this->BASE_URL = $options['base_url'];
                $this->config->set('base_url', $this->BASE_URL);
            }
            if (!empty($options['merchant_email'])) {
                $this->MERCHANT_EMAIL = $options['merchant_email'];
                $this->config->set('merchant_email', $this->MERCHANT_EMAIL);
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
    public function setBaseUrl(string $url = null)
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
    public function SecretKey(string $key = null)
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
    public function setMerchant(string $email = null)
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
    public function setPublicKey(string $key = null)
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
     * @return void
     */
    private function client()
    {
        $url = $this->BASE_URL;
        $secret = $this->SECRET_KEY;
        $this->client = new Client($secret, $url);
        return $this->client;
    }

    public function getConfig()
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
     * @return void
     */
    public function banks(string $country = null, $params = [])
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
     * @return mixed|\Musheabdulhakim\Paystack\Transaction
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
     * @return array|\TransactionSplit
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
            return (new TransactionSplit($this->client))->create($name, $type, $currency, $subaccounts, $bearer_type, $bearer_subaccount);
        } else {
            return (new TransactionSplit($this->client));
        }
    }
}