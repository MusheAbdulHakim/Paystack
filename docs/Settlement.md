### `Settlement`

This class provides methods to interact with the Paystack Settlement API. Settlements represent the payouts of your collected funds from Paystack to your bank account. You can list all your settlements and retrieve the transactions associated with a specific settlement.

| Method Name | Description | Parameters | Return Type | Example Usage |
|---|---|---|---|---|
| `list` | Lists all settlements on your Paystack account. | `array $params = []`: Optional query parameters for filtering or pagination: <br> - `perPage` (int) <br> - `page` (int) <br> - `status` (string, e.g., `'success'`, `'pending'`, `'failed'`) <br> - `from` (datetime) <br> - `to` (datetime) | `array|string` | ```php $client->settlement()->list(['status' => 'success', 'perPage' => 10]); ``` |
| `transactions` | Fetches the list of transactions included in a specific settlement. | `string $id`: The ID of the settlement. <br> `array $params = []`: Optional query parameters for filtering or pagination of transactions within the settlement (e.g., `perPage`, `page`). | `array|string` | ```php $client->settlement()->transactions('settlement_xxxx', ['perPage' => 20]); ``` |

**Usage and Sample Code:**

To use the `Settlement` class, you first need to initialize the Paystack client with your secret key. Once the client is initialized, you can access the `settlement()` method to interact with the Settlement API.

```php
<?php

require 'vendor/autoload.php';

use MusheAbdulHakim\Paystack\Paystack;

// Replace with your actual Paystack secret key
$secretKey = 'sk_test_xxxxxxxxxxxxxxxxxxxxxxxxxxxx';

// Initialize the Paystack client
$client = Paystack::client($secretKey);

// --- Sample Usage for Settlement Class ---

// Note: To run these examples effectively, you would need to have settlements
// on your Paystack account. Settlements typically occur daily or as configured.

// 1. List all settlements
try {
    $allSettlements = $client->settlement()->list(['perPage' => 5, 'status' => 'success']);
    echo "Listing Successful Settlements (first 5):\n";
    if (!empty($allSettlements['data'])) {
        $sampleSettlementId = null;
        foreach ($allSettlements['data'] as $settlement) {
            echo "- Settlement ID: " . $settlement['id'] . ", Amount: " . ($settlement['amount'] / 100) . " " . $settlement['currency'] . ", Status: " . $settlement['status'] . ", Date: " . $settlement['settlement_date'] . "\n";
            if (!$sampleSettlementId) { // Capture the first settlement ID for later use
                $sampleSettlementId = $settlement['id'];
            }
        }
    } else {
        echo "No successful settlements found.\n";
    }
} catch (\Exception $e) {
    echo "Error listing settlements: " . $e->getMessage() . "\n";
    $sampleSettlementId = null;
}

// Ensure a settlement ID is available for fetching transactions
if ($sampleSettlementId) {
    // 2. Fetch transactions within a specific settlement
    try {
        $transactionsInSettlement = $client->settlement()->transactions($sampleSettlementId, ['perPage' => 10]);
        echo "\nListing Transactions for Settlement ID '{$sampleSettlementId}' (first 10):\n";
        if (!empty($transactionsInSettlement['data'])) {
            foreach ($transactionsInSettlement['data'] as $transaction) {
                echo "- Transaction Ref: " . $transaction['reference'] . ", Amount: " . ($transaction['amount'] / 100) . " " . $transaction['currency'] . ", Status: " . $transaction['status'] . "\n";
            }
        } else {
            echo "No transactions found for settlement '{$sampleSettlementId}'.\n";
        }
    } catch (\Exception $e) {
        echo "Error fetching transactions for settlement '{$sampleSettlementId}': " . $e->getMessage() . "\n";
    }
} else {
    echo "\nSkipping fetching settlement transactions as no valid settlement ID was available.\n";
}

?>