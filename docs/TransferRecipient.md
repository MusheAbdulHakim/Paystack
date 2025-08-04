### `TransferRecipient`

This class provides methods to manage transfer recipients on Paystack. A transfer recipient represents a bank account or mobile money wallet to which you can send funds. You can create single recipients, create recipients in bulk, list, fetch, update, and delete them.

| Method Name | Description | Parameters | Return Type | Example Usage |
|---|---|---|---|---|
| `create` | Creates a new transfer recipient. | `array $params`: An array of recipient details: <br> - `type` (string, required): Type of recipient (`'nuban'` for bank account, `'mobile_money'` for mobile money). <br> - `name` (string, required): Name of the recipient. <br> - `account_number` (string, required for `'nuban'`): Bank account number. <br> - `bank_code` (string, required for `'nuban'`): Bank code. <br> - `phone` (string, required for `'mobile_money'`): Mobile money number. <br> - `description` (string, optional): A description for the recipient. <br> - `currency` (string, optional, default: `'NGN'`): Currency of the recipient's account. | `array|string` | ```php $client->transferRecipient()->create(['type' => 'nuban', 'name' => 'John Doe', 'account_number' => '0001234567', 'bank_code' => '044', 'currency' => 'NGN']); ``` |
| `bulk` | Creates multiple transfer recipients in a single request. | `array $batch`: An array of recipient objects, each containing details for a new recipient (same parameters as `create` method). | `array|string` | ```php $client->transferRecipient()->bulk([['type' => 'nuban', 'name' => 'User A', 'account_number' => '0001', 'bank_code' => '044'], ['type' => 'nuban', 'name' => 'User B', 'account_number' => '0002', 'bank_code' => '044']]); ``` |
| `list` | Lists all transfer recipients on your Paystack account. | `array $params = []`: Optional query parameters for filtering or pagination: <br> - `perPage` (int) <br> - `page` (int) <br> - `type` (string, e.g., `'nuban'`, `'mobile_money'`) <br> - `name` (string, filter by recipient name) <br> - `bank_code` (string, filter by bank code) | `array|string` | ```php $client->transferRecipient()->list(['type' => 'nuban', 'perPage' => 10]); ``` |
| `fetch` | Fetches the details of a specific transfer recipient using its ID or recipient code. | `string $id`: The ID or unique code of the transfer recipient. | `array|string` | ```php $client->transferRecipient()->fetch('RCP_xxxx'); ``` |
| `update` | Updates the details of an existing transfer recipient. | `string $id`: The ID or unique code of the transfer recipient. <br> `array $params = []`: An array of parameters to update (e.g., `name`, `description`). | `array|string` | ```php $client->transferRecipient()->update('RCP_xxxx', ['name' => 'Jane Doe Updated']); ``` |
| `delete` | Deletes a transfer recipient. Note that deleting a recipient does not affect past transfers made to them. | `string $id`: The ID or unique code of the transfer recipient to delete. | `array|string` | ```php $client->transferRecipient()->delete('RCP_xxxx'); ``` |

**Usage and Sample Code:**

To use the `TransferRecipient` class, you first need to initialize the Paystack client with your secret key. Once the client is initialized, you can access the `transferRecipient()` method to interact with the Transfer Recipient API.

```php
<?php

require 'vendor/autoload.php';

use MusheAbdulHakim\Paystack\Paystack;

// Replace with your actual Paystack secret key
$secretKey = 'sk_test_xxxxxxxxxxxxxxxxxxxxxxxxxxxx';

// Initialize the Paystack client
$client = Paystack::client($secretKey);

// --- Sample Usage for TransferRecipient Class ---

// 1. Create a new transfer recipient (NUBAN - Bank Account)
try {
    $recipientName = 'Test User ' . uniqid();
    $createRecipientResponse = $client->transferRecipient()->create([
        'type' => 'nuban',
        'name' => $recipientName,
        'account_number' => '0001234567', // Replace with a valid test account number
        'bank_code' => '044', // GTBank (replace with a valid bank code)
        'currency' => 'NGN',
        'description' => 'Personal savings account',
    ]);
    echo "New Transfer Recipient Created:\n";
    print_r($createRecipientResponse);
    $recipientId = $createRecipientResponse['data']['id'] ?? null;
    $recipientCode = $createRecipientResponse['data']['recipient_code'] ?? null;
} catch (\Exception $e) {
    echo "Error creating transfer recipient: " . $e->getMessage() . "\n";
    $recipientId = null;
    $recipientCode = null;
}

// 2. Create multiple transfer recipients in bulk
try {
    $bulkRecipients = [
        [
            'type' => 'nuban',
            'name' => 'Bulk User A ' . uniqid(),
            'account_number' => '0001112223', // Replace with valid test account numbers
            'bank_code' => '044',
            'currency' => 'NGN',
        ],
        [
            'type' => 'nuban',
            'name' => 'Bulk User B ' . uniqid(),
            'account_number' => '0003334445',
            'bank_code' => '044',
            'currency' => 'NGN',
        ],
    ];
    $bulkCreateResponse = $client->transferRecipient()->bulk($bulkRecipients);
    echo "\nBulk Transfer Recipients Created:\n";
    print_r($bulkCreateResponse);
} catch (\Exception $e) {
    echo "Error creating bulk transfer recipients: " . $e->getMessage() . "\n";
}

// 3. List all transfer recipients
try {
    $allRecipients = $client->transferRecipient()->list(['perPage' => 5, 'type' => 'nuban']);
    echo "\nListing NUBAN Transfer Recipients (first 5):\n";
    if (!empty($allRecipients['data'])) {
        foreach ($allRecipients['data'] as $rec) {
            echo "- Name: " . $rec['name'] . ", Code: " . $rec['recipient_code'] . ", Bank: " . $rec['details']['bank_name'] . "\n";
            // Capture a recipient ID/code if not already set, for further operations
            if (!$recipientId && $rec['type'] === 'nuban') {
                $recipientId = $rec['id'];
                $recipientCode = $rec['recipient_code'];
            }
        }
    } else {
        echo "No NUBAN transfer recipients found.\n";
    }
} catch (\Exception $e) {
    echo "Error listing transfer recipients: " . $e->getMessage() . "\n";
}

// Ensure a recipient ID/code is available for fetch/update/delete operations
if ($recipientId || $recipientCode) {
    $idToUse = $recipientId ?: $recipientCode; // Prefer ID if available, otherwise code

    // 4. Fetch details of a specific transfer recipient by ID or code
    try {
        $fetchedRecipient = $client->transferRecipient()->fetch($idToUse);
        echo "\nFetched Transfer Recipient Details for '{$idToUse}':\n";
        print_r($fetchedRecipient);
    } catch (\Exception $e) {
        echo "Error fetching transfer recipient '{$idToUse}': " . $e->getMessage() . "\n";
    }

    // 5. Update an existing transfer recipient (e.g., change name)
    try {
        $updateRecipientResponse = $client->transferRecipient()->update($idToUse, [
            'name' => 'Updated Recipient Name',
            'description' => 'Updated description for this recipient.',
        ]);
        echo "\nTransfer Recipient '{$idToUse}' Updated:\n";
        print_r($updateRecipientResponse);
    } catch (\Exception $e) {
        echo "Error updating transfer recipient: " . $e->getMessage() . "\n";
    }

    // 6. Delete a transfer recipient
    // IMPORTANT: Deleting a recipient is permanent.
    try {
        $deleteRecipientResponse = $client->transferRecipient()->delete($idToUse);
        echo "\nTransfer Recipient '{$idToUse}' Deleted:\n";
        print_r($deleteRecipientResponse);
    } catch (\Exception $e) {
        echo "Error deleting transfer recipient: " . $e->getMessage() . "\n";
    }

} else {
    echo "\nSkipping recipient-specific operations as no valid recipient ID/code was obtained.\n";
}

?>