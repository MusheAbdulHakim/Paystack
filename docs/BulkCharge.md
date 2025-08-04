### `BulkCharge`

This class provides methods to interact with the Paystack Bulk Charge API, enabling you to initiate, list, fetch details, pause, and resume bulk charge operations.

| Method Name | Description | Parameters | Return Type | Example Usage |
|---|---|---|---|---|
| `init` | Initiates a new bulk charge. | `array $params`: An array containing `authorizations` (array of authorization codes) and `amount` (amount in kobo for each charge). | `array|string` | ```php $client->bulkCharge()->init(['authorizations' => ['AUTH_xxxx', 'AUTH_yyyy'], 'amount' => 50000]); ``` |
| `list` | Lists bulk charge batches. | `array $params = []`: Optional query parameters for filtering or pagination (e.g., `perPage`, `page`, `status`). | `array|string` | ```php $client->bulkCharge()->list(['status' => 'active']); ``` |
| `fetch` | Fetches the details of a specific bulk charge batch. | `string $id`: The ID of the bulk charge batch. | `array|string` | ```php $client->bulkCharge()->fetch('bulkcharge_xxxx'); ``` |
| `batch` | Fetches the charges within a specific bulk charge batch. | `string $id`: The ID of the bulk charge batch. <br> `array $params = []`: Optional query parameters for filtering or pagination of charges within the batch. | `array|string` | ```php $client->bulkCharge()->batch('bulkcharge_xxxx', ['status' => 'success']); ``` |
| `pause` | Pauses a bulk charge batch. | `string $code`: The batch code of the bulk charge to pause. | `array|string` | ```php $client->bulkCharge()->pause('BCH_xxxx'); ``` |
| `resume` | Resumes a paused bulk charge batch. | `string $code`: The batch code of the bulk charge to resume. | `array|string` | ```php $client->bulkCharge()->resume('BCH_xxxx'); ``` |

**Usage and Sample Code:**

To use the `BulkCharge` class, you first need to initialize the Paystack client with your secret key. Once the client is initialized, you can access the `bulkCharge()` method to interact with the Bulk Charge API.

```php
<?php

require 'vendor/autoload.php';

use MusheAbdulHakim\Paystack\Paystack;

// Replace with your actual Paystack secret key
$secretKey = 'sk_test_xxxxxxxxxxxxxxxxxxxxxxxxxxxx';

// Initialize the Paystack client
$client = Paystack::client($secretKey);

// --- Sample Usage for BulkCharge Class ---

// 1. Initiate a new bulk charge
// This allows you to charge multiple customers using their authorization codes.
// Ensure you have valid authorization codes from previous transactions.
try {
    $bulkChargeParams = [
        'authorizations' => [
            'AUTH_xxxxxxxxxxxxxxx', // Replace with a valid authorization code
            'AUTH_yyyyyyyyyyyyyyy', // Replace with another valid authorization code
            // Add more authorization codes as needed
        ],
        'amount' => 100000, // Amount in kobo (e.g., NGN 1000.00) for EACH charge
    ];
    $initiateResponse = $client->bulkCharge()->init($bulkChargeParams);
    echo "Bulk Charge Initiated Successfully:\n";
    print_r($initiateResponse);
    $batchCode = $initiateResponse['data'][0]['batch_code'] ?? null; // Get the batch code for further actions
} catch (\Exception $e) {
    echo "Error initiating bulk charge: " . $e->getMessage() . "\n";
    $batchCode = null;
}

// 2. List bulk charge batches
// This retrieves a list of all your bulk charge operations.
try {
    $bulkChargeBatches = $client->bulkCharge()->list(['perPage' => 5, 'page' => 1]);
    echo "\nBulk Charge Batches:\n";
    if (!empty($bulkChargeBatches['data'])) {
        foreach ($bulkChargeBatches['data'] as $batch) {
            echo "- Batch Code: " . $batch['batch_code'] . ", Status: " . $batch['status'] . ", Total Charges: " . $batch['total_charges'] . "\n";
        }
    } else {
        echo "No bulk charge batches found.\n";
    }
} catch (\Exception $e) {
    echo "Error listing bulk charge batches: " . $e->getMessage() . "\n";
}

// Assuming we have a batch code from the initiation step or a known one
if ($batchCode) {
    // 3. Fetch details of a specific bulk charge batch
    // Get detailed information about a particular bulk charge operation.
    try {
        $fetchedBatch = $client->bulkCharge()->fetch($batchCode);
        echo "\nDetails for Batch Code '{$batchCode}':\n";
        print_r($fetchedBatch);
    } catch (\Exception $e) {
        echo "Error fetching bulk charge batch '{$batchCode}': " . $e->getMessage() . "\n";
    }

    // 4. Fetch charges within a specific bulk charge batch
    // Get details of individual charges within a bulk charge batch.
    try {
        $chargesInBatch = $client->bulkCharge()->batch($batchCode, ['status' => 'success']);
        echo "\nSuccessful Charges in Batch '{$batchCode}':\n";
        print_r($chargesInBatch);
    } catch (\Exception $e) {
        echo "Error fetching charges in batch '{$batchCode}': " . $e->getMessage() . "\n";
    }

    // 5. Pause a bulk charge batch (if it's active)
    // This stops further charges from being processed in the batch.
    // Make sure the batch is not already completed or paused.
    // NOTE: For demonstration, you might need to run `init` first to get an active batch.
    // If $batchCode is from a 'completed' batch, this will fail.
    try {
        // You might need to make sure the batch is in a state that can be paused (e.g., 'active')
        // For testing, ensure your $batchCode corresponds to a running or pending batch.
        $pauseResponse = $client->bulkCharge()->pause($batchCode);
        echo "\nBulk Charge Batch '{$batchCode}' Paused Successfully:\n";
        print_r($pauseResponse);
    } catch (\Exception $e) {
        echo "Error pausing bulk charge batch '{$batchCode}': " . $e->getMessage() . "\n";
    }

    // 6. Resume a paused bulk charge batch
    // This restarts a paused bulk charge operation.
    // Make sure the batch was successfully paused in the previous step or is known to be paused.
    try {
        // You might need to make sure the batch is actually paused.
        $resumeResponse = $client->bulkCharge()->resume($batchCode);
        echo "\nBulk Charge Batch '{$batchCode}' Resumed Successfully:\n";
        print_r($resumeResponse);
    } catch (\Exception $e) {
        echo "Error resuming bulk charge batch '{$batchCode}': " . $e->getMessage() . "\n";
    }
} else {
    echo "\nSkipping batch-specific operations as no valid batch code was obtained from initiation.\n";
}

?>