<?php
declare(strict_types=1);

namespace Musheabdulhakim\Paystack\Api;

use Musheabdulhakim\Paystack\Contracts\PaystackClientInterface;

/**
 * The Bulk Charges Class allows you create and manage multiple recurring payments from your customers.
 * @link https://paystack.com/docs/api/bulk-charge#bulk-charges
 */
class BulkCharge {

    private $client;

    public function __construct(PaystackClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * Send an array of objects with authorization codes and amount (in kobo if currency is NGN, pesewas, if currency is GHS, and cents if currency is ZAR ) so we can process transactions as a batch.
     *
     * @param array $params A list of charge object. Each object consists of an authorization, amount and reference
     * @return array
     * @link https://www.https://paystack.com/docs/api/bulk-charge#initiate.com
     */
    public function init($params = []): array
    {
        return $this->client->post('bulkcharge', $params);
    }

    /**
     * This lists all bulk charge batches created by the integration. Statuses can be active, paused, or complete
     *
     * @param array $params Query parameters. Refer to the docs
     * @return array
     * @link https://paystack.com/docs/api/bulk-charge#list
     */
    public function list($params = []): array
    {
        return $this->client->get('bulkcharge', $params);
    }

    /**
     * This method retrieves a specific batch code. It also returns useful information on its progress by way of the total_charges and pending_charges attributes.
     *
     * @param string $id_or_code An ID or code for the charge whose batches you want to retrieve.
     * @return array
     * @link https://paystack.com/docs/api/bulk-charge#fetch-charge
     */
    public function fetch(string $id_or_code): array
    {
        return $this->client->get("bulkcharge/{$id_or_code}");
    }

    /**
     * This method retrieves the charges associated with a specified batch code. Pagination parameters are available. You can also filter by status. Charge statuses can be pending, success or failed.
     *
     * @param string $id_or_code An ID or code for the batch whose charges you want to retrieve.
     * @param array $params Query parameters. Refer to the docs
     * @return array
     * @link https://paystack.com/docs/api/bulk-charge#fetch-charge
     */
    public function charges(string $id_or_code, $params = []): array
    {
        return $this->client->get("bulkcharge/{$id_or_code}/charges", $params);
    }

    /**
     * Use this method to pause processing a batch
     *
     * @param string $batch_code The batch code for the bulk charge you want to pause
     * @return array
     * @link https://paystack.com/docs/api/bulk-charge#pause
     */
    public function pause(string $batch_code): array
    {
        return $this->client->get("bulkcharge/pause/{$batch_code}");

    }

    /**
     * Use this endpoint to resume processing a batch
     *
     * @param string $batch_code The batch code for the bulk charge you want to resume
     * @return array
     * @link https://paystack.com/docs/api/bulk-charge#resume
     */
    public function resume(string $batch_code): array
    {
        return $this->client->get("bulkcharge/resume/{$batch_code}");
    }

}
