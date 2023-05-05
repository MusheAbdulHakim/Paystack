<?php
declare(strict_types=1);

namespace Musheabdulhakim\Paystack\Api;

use Musheabdulhakim\Paystack\Contracts\PaystackClientInterface;

/**
 * The Transfer Recipients API allows you create and manage beneficiaries that you send money to.
 * @link https://paystack.com/docs/api/transfer-recipient#transfers-recipients
 */
class TransferRecipient
{

    private $client;

    public function __construct(PaystackClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * Creates a new recipient. A duplicate account number will lead to the retrieval of the existing record.
     *
     * @param string $type Recipient Type. It could be one of: nuban, mobile_money or basa
     * @param string $name A name for the recipient
     * @param string $account_number Required if type is nuban or basa
     * @param string $bank_code Required if type is nuban or basa. You can get the list of Bank Codes by calling the List Banks endpoint.
     * @param string $currency Currency for the account receiving the transfer
     * @param array $params Optional parameters. Refer to the docs
     * @return array
     * @link https://paystack.com/docs/api/transfer-recipient#create
     */
    public function create(string $type, string $name, string $account_number, string $bank_code, string $currency, $params = []): array
    {
        $params['type'] = $type;
        $params['name'] = $name;
        $params['account_number'] = $account_number;
        $params['bank_code'] = $bank_code;
        $params['currency'] = $currency;
        return $this->client->post("transferrecipient", $params);
    }

    /**
     * Create multiple transfer recipients in batches. A duplicate account number will lead to the retrieval of the existing record.
     *
     * @param array $batch A list of transfer recipient object. Each object should contain type, name, and bank_code. Any Create Transfer Recipient param can also be passed. @link https://paystack.com/docs/api/transfer-recipient#create
     * @return array
     * @link https://paystack.com/docs/api/transfer-recipient#bulk
     */
    public function bulk(array $batch): array
    {
        $params['batch'] = $batch;
        return $this->client->post("transferrecipient/bulk", $params);
    }

    /**
     * List transfer recipients available on your integration
     *
     * @param array $params Query parameters. Refer to the docs
     * @return array
     * @link https://paystack.com/docs/api/transfer-recipient#list
     */
    public function list($params = []): array
    {
        return $this->client->get('transferrecipient', $params);
    }
    /**
     * Fetch the details of a transfer recipient
     *
     * @param string $id_or_code An ID or code for the recipient whose details you want to receive.
     * @return array
     * @link https://paystack.com/docs/api/transfer-recipient#fetch
     */
    public function fetch(string $id_or_code): array
    {
        return $this->client->get("transferrecipient/{$id_or_code}");
    }

    /**
     * Update transfer recipients available on your integration
     *
     * @param string $id_or_code
     * @param string $name A name for the recipient
     * @param array $params Optional parameters
     * @return array
     * @link https://paystack.com/docs/api/transfer-recipient#update
     */
    public function update(string $id_or_code, string $name, $params = []): array
    {
        $params['name'] = $name;
        return $this->client->put("transferrecipient/{$id_or_code}", $params);
    }

    /**
     * Delete a transfer recipient (sets the transfer recipient to inactive)
     *
     * @param string $id_or_code An ID or code for the recipient who you want to delete.
     * @return array
     * @link https://paystack.com/docs/api/transfer-recipient#delete
     */
    public function delete(string $id_or_code): array
    {
        return $this->client->delete("transferrecipient/{$id_or_code}");
    }
}
