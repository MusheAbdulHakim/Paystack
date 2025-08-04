### `Dispute`

This class provides methods to interact with the Paystack Dispute API, allowing you to manage disputes, retrieve evidence, and resolve them. This is crucial for handling chargebacks and ensuring proper documentation.

| Method Name | Description | Parameters | Return Type | Example Usage |
|---|---|---|---|---|
| `list` | Lists all disputes on your Paystack account. | `array $params = []`: Optional query parameters for filtering or pagination (e.g., `perPage`, `page`, `status`, `from`, `to`). | `array|string` | ```php $client->dispute()->list(['status' => 'awaiting_merchant_feedback', 'perPage' => 10]); ``` |
| `fetch` | Fetches the details of a specific dispute using its ID. | `string $id`: The ID of the dispute. | `array|string` | ```php $client->dispute()->fetch('dispute_xxxx'); ``` |
| `transactions` | Fetches the transaction associated with a dispute using the transaction ID. | `string $id`: The ID of the transaction related to the dispute. | `array|string` | ```php $client->dispute()->transactions('transaction_xxxx'); ``` |
| `update` | Updates the details of an existing dispute. This can be used to provide additional information or change its status. | `string $id`: The ID of the dispute. <br> `array $params = []`: An array of parameters to update the dispute (e.g., `transaction_id`, `dispute_reason`, `dispute_amount`, `customer_note`). | `array|string` | ```php $client->dispute()->update('dispute_xxxx', ['customer_note' => 'Customer claims item not received.']); ``` |
| `evidence` | Uploads evidence for a dispute. This is critical for defending against chargebacks. | `string $id`: The ID of the dispute. <br> `array $params = []`: An array containing the evidence details. Common parameters include: <br> - `customer_email` (string) <br> - `customer_name` (string) <br> - `delivery_address` (string) <br> - `delivery_date` (string, `YYYY-MM-DD`) <br> - `proof_of_delivery_url` (string, URL to evidence) <br> - `proof_of_refund_url` (string, URL to evidence) <br> - `call_log_url` (string, URL to evidence) <br> - `refund_proof` (string, URL to evidence) <br> - `additional_documentation` (string, URL to evidence) | `array|string` | ```php $client->dispute()->evidence('dispute_xxxx', ['customer_email' => 'customer@example.com', 'proof_of_delivery_url' => '[https://yourdomain.com/evidence/pod_123.pdf](https://yourdomain.com/evidence/pod_123.pdf)']); ``` |
| `uploadUrl` | Retrieves a URL that you can use to upload dispute evidence files directly to Paystack's storage. | `string $id`: The ID of the dispute. <br> `array $params = []`: Optional query parameters. | `array|string` | ```php $client->dispute()->uploadUrl('dispute_xxxx'); ``` |
| `resolve` | Resolves a dispute by accepting or declining the chargeback. | `string $id`: The ID of the dispute. <br> `array $params`: An array containing resolution details: <br> - `resolution` (string, `'merchant_accepted'` or `'merchant_declined'`) <br> - `message` (string, required, reason for resolution) <br> - `refund_amount` (int, optional, if `merchant_accepted` and refund is partial/different) <br> - `uploaded_proof` (string, optional, ID of uploaded evidence if applicable) <br> - `evidence_id` (string, optional, ID of evidence if already uploaded) | `array|string` | ```php $client->dispute()->resolve('dispute_xxxx', ['resolution' => 'merchant_declined', 'message' => 'Customer received goods as per tracking.']); ``` |
| `export` | Exports a list of disputes, useful for reporting and analysis. | `array $params = []`: Optional query parameters for filtering the export (e.g., `status`, `from`, `to`, `perPage`, `page`). | `array|string` | ```php $client->dispute()->export(['status' => 'resolved', 'from' => '2024-01-01']); ``` |

**Usage and Sample Code:**

To use the `Dispute` class, you first need to initialize the Paystack client with your secret key. Once the client is initialized, you can access the `dispute()` method to interact with the Dispute API.

```php
<?php

require 'vendor/autoload.php';

use MusheAbdulHakim\Paystack\Paystack;

// Replace with your actual Paystack secret key
$secretKey = 'sk_test_xxxxxxxxxxxxxxxxxxxxxxxxxxxx';

// Initialize the Paystack client
$client = Paystack::client($secretKey);

// --- Sample Usage for Dispute Class ---

// Note: To run these examples effectively, you would ideally have existing disputes
// on your Paystack account. You can create test disputes via the Paystack dashboard
// or by simulating chargebacks in a test environment.

// Let's assume you have a dispute ID (replace with a real one from your Paystack dashboard)
$sampleDisputeId = 'dispute_xxxxxxxxxxxx'; // Example: 'dispute_1234567890'
$sampleTransactionId = 'transaction_yyyyyyyyyyyy'; // Example: 'transaction_1234567890'

// 1. List all disputes
try {
    $disputes = $client->dispute()->list(['perPage' => 5, 'status' => 'awaiting_merchant_feedback']);
    echo "Listing Disputes (Awaiting Merchant Feedback):\n";
    if (!empty($disputes['data'])) {
        foreach ($disputes['data'] as $dispute) {
            echo "- Dispute ID: " . $dispute['id'] . ", Reason: " . $dispute['dispute_reason'] . ", Status: " . $dispute['status'] . "\n";
            // Set a sample dispute ID if we find one
            if (!$sampleDisputeId && $dispute['status'] === 'awaiting_merchant_feedback') {
                $sampleDisputeId = $dispute['id'];
            }
        }
    } else {
        echo "No disputes found matching criteria.\n";
    }
} catch (\Exception $e) {
    echo "Error listing disputes: " . $e->getMessage() . "\n";
}

// Ensure we have a dispute ID to proceed with other operations
if ($sampleDisputeId) {
    // 2. Fetch details of a specific dispute
    try {
        $fetchedDispute = $client->dispute()->fetch($sampleDisputeId);
        echo "\nFetched Dispute Details for ID '{$sampleDisputeId}':\n";
        print_r($fetchedDispute);
        $sampleTransactionId = $fetchedDispute['data']['transaction']['id'] ?? $sampleTransactionId; // Get associated transaction ID
    } catch (\Exception $e) {
        echo "Error fetching dispute '{$sampleDisputeId}': " . $e->getMessage() . "\n";
    }

    // 3. Fetch transaction associated with a dispute
    if ($sampleTransactionId) {
        try {
            $disputeTransaction = $client->dispute()->transactions($sampleTransactionId);
            echo "\nTransaction associated with dispute (ID '{$sampleTransactionId}'):\n";
            print_r($disputeTransaction);
        } catch (\Exception $e) {
            echo "Error fetching transaction for dispute '{$sampleTransactionId}': " . $e->getMessage() . "\n";
        }
    } else {
        echo "\nSkipping fetching dispute transaction as no valid transaction ID was found.\n";
    }

    // 4. Update a dispute (e.g., add a merchant note)
    try {
        $updateResponse = $client->dispute()->update($sampleDisputeId, [
            'merchant_note' => 'Investigating customer claim. Will provide evidence soon.',
        ]);
        echo "\nDispute '{$sampleDisputeId}' Updated:\n";
        print_r($updateResponse);
    } catch (\Exception $e) {
        echo "Error updating dispute '{$sampleDisputeId}': " . $e->getMessage() . "\n";
    }

    // 5. Upload evidence for a dispute
    // In a real scenario, you would have actual URLs to your hosted evidence files.
    try {
        $evidenceParams = [
            'customer_email' => 'customer@example.com', // Email of the customer involved
            'customer_name' => 'John Doe',
            'delivery_address' => '123 Main St, City, Country',
            'delivery_date' => '2024-07-20', // YYYY-MM-DD
            'proof_of_delivery_url' => '[https://your-storage.com/evidence/pod_dispute_123.pdf](https://your-storage.com/evidence/pod_dispute_123.pdf)',
            'additional_documentation' => '[https://your-storage.com/evidence/chat_logs_dispute_123.zip](https://your-storage.com/evidence/chat_logs_dispute_123.zip)',
        ];
        $evidenceResponse = $client->dispute()->evidence($sampleDisputeId, $evidenceParams);
        echo "\nEvidence Uploaded for Dispute '{$sampleDisputeId}':\n";
        print_r($evidenceResponse);
        $evidenceId = $evidenceResponse['data']['id'] ?? null;
    } catch (\Exception $e) {
        echo "Error uploading evidence for dispute '{$sampleDisputeId}': " . $e->getMessage() . "\n";
        $evidenceId = null;
    }

    // 6. Get upload URL for dispute evidence
    // This provides a temporary URL to directly upload files.
    try {
        $uploadUrlResponse = $client->dispute()->uploadUrl($sampleDisputeId);
        echo "\nDispute Evidence Upload URL for '{$sampleDisputeId}':\n";
        print_r($uploadUrlResponse);
        // In a real application, you would then use this URL to upload your file.
    } catch (\Exception $e) {
        echo "Error getting upload URL for dispute '{$sampleDisputeId}': " . $e->getMessage() . "\n";
    }

    // 7. Resolve a dispute
    // IMPORTANT: Resolving a dispute is a final action. Use with caution.
    // Ensure you have provided all necessary evidence before resolving.
    try {
        $resolveParams = [
            'resolution' => 'merchant_declined', // or 'merchant_accepted'
            'message' => 'Customer received the service as agreed. Evidence provided.',
            // 'uploaded_proof' => $evidenceId, // If you have an evidence ID from a previous upload
        ];
        $resolveResponse = $client->dispute()->resolve($sampleDisputeId, $resolveParams);
        echo "\nDispute '{$sampleDisputeId}' Resolved:\n";
        print_r($resolveResponse);
    } catch (\Exception $e) {
        echo "Error resolving dispute '{$sampleDisputeId}': " . $e->getMessage() . "\n";
    }

} else {
    echo "\nSkipping dispute-specific operations as no valid dispute ID was available.\n";
}

// 8. Export disputes
try {
    $exportParams = [
        'status' => 'resolved',
        'from' => '2024-01-01',
        'to' => date('Y-m-d'),
    ];
    $exportResponse = $client->dispute()->export($exportParams);
    echo "\nDispute Export Initiated:\n";
    print_r($exportResponse);
    // The response will contain a URL to download the exported file.
} catch (\Exception $e) {
    echo "Error exporting disputes: " . $e->getMessage() . "\n";
}

?>