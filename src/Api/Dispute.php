<?php
declare(strict_types=1);

namespace Musheabdulhakim\Paystack\Api;
use Musheabdulhakim\Paystack\Contracts\PaystackClientInterface;

/**
 * The Disputes Class allows you manage transaction disputes on your integration.
 * @link https://paystack.com/docs/api/dispute#disputes
 */
class Dispute
{
    private $client;

    public function __construct(PaystackClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * List disputes filed against you
     *
     * @param string|null $from A timestamp from which to start listing dispute e.g. 2016-09-21
     * @param string|null $to A timestamp at which to stop listing dispute e.g. 2016-09-21
     * @param array $params Optional query parameters. Refer to the docs
     * @return array
     * @link https://paystack.com/docs/api/dispute#list
     */
    public function list(string $from = null, string $to = null, $params = []): array
    {
        $params['from'] = $from ?? null;
        $params['to'] = $to ?? null;
        return $this->client->get('dispute', $params);
    }

    /**
     * Get more details about a dispute.
     *
     * @param string $id The dispute ID you want to fetch
     * @return array
     * @link https://paystack.com/docs/api/dispute#fetch
     */
    public function get(string $id): array
    {
        return $this->client->get("dispute/{$id}");
    }

    /**
     * Get more details about a dispute.
     *
     * @param string $id The dispute ID you want to fetch
     * @return array
     * @link https://paystack.com/docs/api/dispute#fetch
     */
    public function fetch(string $id): array
    {
        return $this->client->get("dispute/{$id}");
    }

    /**
     * This method retrieves disputes for a particular transaction
     *
     * @param string $id The transaction ID you want to fetch
     * @return array
     * @link https://paystack.com/docs/api/dispute#transaction
     */
    public function transaction(string $id): array
    {
        return $this->client->get("dispute/transaction/{$id}");
    }

    /**
     * Update details of a dispute on your integration
     *
     * @param string $id Dispute ID
     * @param integer $refund_amount the amount to refund, in kobo if currency is NGN, pesewas, if currency is GHS, and cents, if currency is ZAR
     * @param array $params Optional parameters. Refer to the docs
     * @return array
     * @link https://paystack.com/docs/api/dispute#update
     */
    public function update(string $id, int $refund_amount, $params = []): array
    {
        $params['refund_amount'] = $refund_amount;
        return $this->client->put("dispute/{$id}", $params);

    }

    /**
     * Provide evidence for a dispute
     *
     * @param string $id Dispute ID
     * @param string $customer_email Customer email
     * @param string $customer_name Customer name
     * @param string $customer_phone Customer phone
     * @param string $service_details Details of service involved
     * @param array $params
     * @return array
     * @link https://paystack.com/docs/api/dispute#evidence
     */
    public function evidence(string $id, string $customer_email, string $customer_name, string $customer_phone, string $service_details, $params = []): array
    {
        $params['customer_email'] = $customer_email;
        $params['customer_name'] = $customer_name;
        $params['customer_phone'] = $customer_phone;
        $params['service_details'] = $service_details;
        return $this->client->post("dispute/{$id}/evidence", $params);
    }

    /**
     * This method retrieves disputes for a particular transaction
     *
     * @param string $id Dispute Id
     * @param string $upload_filename The file name, with its extension, that you want to upload. e.g filename.pdf
     * @return array
     * @link https://paystack.com/docs/api/dispute#upload-url
     */
    public function upload(string $id, string $upload_filename): array
    {
        $params['upload_filename'] = $upload_filename;
        return $this->client->get("dispute/{$id}/upload_url", $params);
    }

    /**
     * Resolve a dispute on your integration
     *
     * @param string $id Dispute ID
     * @param string $resolution Dispute resolution. Accepted values: { merchant-accepted | declined }.
     * @param string $message Reason for resolving
     * @param integer $refund_amount Reason for resolving
     * @param string $upload_filename filename of attachment returned via response from upload url(GET /dispute/:id/upload_url)
     * @param array $params Optional parameters. Refer to the docs
     * @return array
     * @link https://paystack.com/docs/api/dispute#resolve
     */
    public function resolve(string $id, string $resolution, string $message, int $refund_amount, string $upload_filename, $params = []): array
    {
        $params['resolution'] = $resolution;
        $params['message'] = $message;
        $params['refund_amount'] = $refund_amount;
        $params['uploaded_filename'] = $upload_filename;
        return $this->client->put("dispute/{$id}/resolve", $params);
    }

    /**
     * Export disputes available on your integration
     *
     * @param array $params Query parameters
     * @return array
     * @link https://paystack.com/docs/api/dispute#export
     */
    public function export($params = []): array
    {
        return $this->client->get("dispute/export", $params);
    }
}
