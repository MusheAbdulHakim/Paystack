### `Refund`

This class provides methods to interact with the Paystack Refund API, allowing you to create, list, and fetch details of refunds. Refunds are used to return money to customers for transactions that have already been completed.

| Method Name | Description | Parameters | Return Type | Example Usage |
|---|---|---|---|---|
| `create` | Initiates a new refund for a given transaction. | `string $transaction`: The transaction ID or transaction reference to refund. <br> `array $params = []`: Optional parameters for the refund: <br> - `amount` (int, optional): The amount to refund in kobo. If not provided, the full transaction amount will be refunded. <br> - `reason` (string, optional): The reason for the refund (e.g., `'duplicate_transaction'`, `'customer_request'`). | `array|string` | ```php $client->refund()->create('transaction_ref_123', ['amount' => 50000, 'reason' => 'customer_request']); ``` |
| `list` | Lists all refunds for a specific transaction. | `string $transaction`: The transaction ID or transaction reference to list refunds for. <br> `array $params = []`: Optional query parameters for filtering or pagination (e.g., `perPage`, `page`). | `array|string` | ```php $client->refund()->list('transaction_ref_123', ['perPage' => 5]); ``` |
| `fetch` | Fetches the details of a specific refund using its ID. | `string $id`: The ID of the refund. | `array|string` | ```php $client->refund()->fetch('refund_xxxx'); ``` |

**Usage and Sample Code:**

To use the `Refund` class, you first need to initialize the Paystack client with your secret key. Once the client is initialized, you can access the `refund()` method to interact with the Refund API.

```php
<?php

require 'vendor/autoload.php';

use MusheAbdulHakim\Paystack\Paystack;

// Replace with your actual Paystack secret key
$secretKey = 'sk_test_xxxxxxxxxxxxxxxxxxxxxxxxxxxx';

// Initialize the Paystack client
$client = Paystack::client($secretKey);

// --- Sample Usage for Refund Class ---

// Note: To demonstrate refunds, you need a successful transaction ID or reference.
// Replace 'TRANSACTION_ID_OR_REF' with an actual successful transaction from your Paystack account.
$sampleTransactionReference = 'T1234567890'; // Example: 'T1234567890' or 'transaction_ref_abc'
$sampleTransactionAmount = 1000000; // Example: NGN 10,000.00 in kobo

// 1. Create a new refund (partial refund example)
try {
    $refundAmount = 500000; // NGN 5,000.00
    $createRefundResponse = $client->refund()->create($sampleTransactionReference, [
        'amount' => $refundAmount,
        'reason' => 'Customer changed mind',
    ]);
    echo "Partial Refund Created for Transaction '{$sampleTransactionReference}':\n";
    print_r($createRefundResponse);
    $refundId = $createRefundResponse['data']['id'] ?? null;
} catch (\Exception $e) {
    echo "Error creating refund: " . $e->getMessage() . "\n";
    $refundId = null;
}

// 2. Create a new refund (full refund example - if no amount is specified)
// This will only work if the transaction hasn't been refunded yet or is partially refunded.
// For demonstration, we'll use a different transaction reference.
$anotherTransactionReference = 'T0987654321'; // Replace with another successful transaction
try {
    $createFullRefundResponse = $client->refund()->create($anotherTransactionReference, [
        'reason' => 'Product returned',
    ]); // No amount specified for full refund
    echo "\nFull Refund Created for Transaction '{$anotherTransactionReference}':\n";
    print_r($createFullRefundResponse);
} catch (\Exception $e) {
    echo "Error creating full refund: " . $e->getMessage() . "\n";
}


// 3. List all refunds for a specific transaction
// This will show the refund(s) created above for $sampleTransactionReference.
try {
    $refundsForTransaction = $client->refund()->list($sampleTransactionReference);
    echo "\nListing Refunds for Transaction '{$sampleTransactionReference}':\n";
    if (!empty($refundsForTransaction['data'])) {
        foreach ($refundsForTransaction['data'] as $refund) {
            echo "- Refund ID: " . $refund['id'] . ", Amount: " . ($refund['amount'] / 100) . " " . $refund['currency'] . ", Status: " . $refund['status'] . "\n";
        }
    } else {
        echo "No refunds found for transaction '{$sampleTransactionReference}'.\n";
    }
} catch (\Exception $e) {
    echo "Error listing refunds: " . $e->getMessage() . "\n";
}

// Ensure a refund ID is available for fetch operation
if ($refundId) {
    // 4. Fetch details of a specific refund
    try {
        $fetchedRefund = $client->refund()->fetch($refundId);
        echo "\nFetched Refund Details for ID '{$refundId}':\n";
        print_r($fetchedRefund);
    } catch (\Exception $e) {
        echo "Error fetching refund '{$refundId}': " . $e->getMessage() . "\n";
    }
} else {
    echo "\nSkipping fetch refund operation as no valid refund ID was obtained from creation.\n";
}

?>