### `TransactionSplit`

This class provides methods to interact with the Paystack Transaction Split API. Transaction Splits allow you to automatically divide payments received among multiple recipients (e.g., subaccounts, your main account) based on predefined rules. This is ideal for marketplaces, co-working spaces, or any business needing to disburse funds from a single transaction.

| Method Name | Description | Parameters | Return Type | Example Usage |
|---|---|---|---|---|
| `create` | Creates a new transaction split. | `array $params`: An array of parameters for the split: <br> - `name` (string, required): Name of the split. <br> - `type` (string, required): Type of split (`'flat'` or `'percentage'`). <br> - `currency` (string, required): Currency of the split. <br> - `subaccounts` (array, required): An array of subaccount objects, each with `subaccount` (code/ID) and `share` (amount in kobo for `'flat'`, or percentage for `'percentage'`). <br> - `bearer_type` (string, optional, default: `'account'`): Who bears the transaction charges (`'account'`, `'subaccount'`, `'flat'`, `'percentage'`). <br> - `bearer_subaccount` (string, optional): Subaccount code if `bearer_type` is `'subaccount'`. | `array|string` | ```php $client->transactionSplit()->create(['name' => 'Freelancer Payout', 'type' => 'percentage', 'currency' => 'NGN', 'subaccounts' => [['subaccount' => 'ACCT_xxxx', 'share' => 70], ['subaccount' => 'ACCT_yyyy', 'share' => 30]], 'bearer_type' => 'subaccount', 'bearer_subaccount' => 'ACCT_xxxx']); ``` |
| `list` | Lists all transaction splits on your Paystack account. | `array $params = []`: Optional query parameters for filtering or pagination: <br> - `perPage` (int) <br> - `page` (int) <br> - `name` (string, filter by split name) <br> - `active` (bool, filter by active status) <br> - `sort_by` (string, e.g., `'name'`, `'created_at'`) | `array|string` | ```php $client->transactionSplit()->list(['active' => true, 'perPage' => 10]); ``` |
| `fetch` | Fetches the details of a specific transaction split using its ID or name. | `string $reference`: The ID or unique name of the transaction split. | `array|string` | ```php $client->transactionSplit()->fetch('split_xxxx'); ``` |
| `update` | Updates the details of an existing transaction split. | `string $id`: The ID of the transaction split. <br> `array $params = []`: An array of parameters to update (e.g., `name`, `active`, `bearer_type`, `bearer_subaccount`). | `array|string` | ```php $client->transactionSplit()->update('split_xxxx', ['name' => 'Updated Freelancer Split', 'active' => false]); ``` |
| `addSubAccount` | Adds a subaccount to an existing transaction split. | `string $id`: The ID of the transaction split. <br> `array $params`: An array containing: <br> - `subaccount` (string, required): The code or ID of the subaccount to add. <br> - `share` (int, required): The share amount (kobo for flat, percentage for percentage split). | `array|string` | ```php $client->transactionSplit()->addSubAccount('split_xxxx', ['subaccount' => 'ACCT_zzzz', 'share' => 10]); ``` |
| `removeSubAccount` | Removes a subaccount from an existing transaction split. | `string $id`: The ID of the transaction split. <br> `array $params`: An array containing: <br> - `subaccount` (string, required): The code or ID of the subaccount to remove. | `array|string` | ```php $client->transactionSplit()->removeSubAccount('split_xxxx', ['subaccount' => 'ACCT_zzzz']); ``` |

**Usage and Sample Code:**

To use the `TransactionSplit` class, you first need to initialize the Paystack client with your secret key. Once the client is initialized, you can access the `transactionSplit()` method to interact with the Transaction Split API.

```php
<?php

require 'vendor/autoload.php';

use MusheAbdulHakim\Paystack\Paystack;

// Replace with your actual Paystack secret key
$secretKey = 'sk_test_xxxxxxxxxxxxxxxxxxxxxxxxxxxx';

// Initialize the Paystack client
$client = Paystack::client($secretKey);

// --- Sample Usage for TransactionSplit Class ---

// Prerequisites:
// You need existing subaccounts to create a transaction split.
// If you don't have any, create them first using the SubAccount API.
// Example dummy subaccount codes:
$subaccount1Code = 'ACCT_test_sub_1'; // Replace with a real subaccount code
$subaccount2Code = 'ACCT_test_sub_2'; // Replace with another real subaccount code

// 1. Create a new transaction split (percentage split example)
try {
    $splitName = 'Team Payout Split ' . uniqid();
    $createSplitResponse = $client->transactionSplit()->create([
        'name' => $splitName,
        'type' => 'percentage',
        'currency' => 'NGN',
        'subaccounts' => [
            ['subaccount' => $subaccount1Code, 'share' => 70], // 70% to subaccount 1
            ['subaccount' => $subaccount2Code, 'share' => 30], // 30% to subaccount 2
        ],
        'bearer_type' => 'account', // Your main account bears the charges
        // 'bearer_type' => 'subaccount', // A subaccount bears the charges
        // 'bearer_subaccount' => $subaccount1Code, // If bearer_type is 'subaccount'
    ]);
    echo "New Transaction Split Created:\n";
    print_r($createSplitResponse);
    $splitId = $createSplitResponse['data']['id'] ?? null;
    $splitCode = $createSplitResponse['data']['split_code'] ?? null;
} catch (\Exception $e) {
    echo "Error creating transaction split: " . $e->getMessage() . "\n";
    $splitId = null;
    $splitCode = null;
}

// 2. List all transaction splits
try {
    $allSplits = $client->transactionSplit()->list(['perPage' => 5, 'active' => true]);
    echo "\nListing Active Transaction Splits (first 5):\n";
    if (!empty($allSplits['data'])) {
        foreach ($allSplits['data'] as $split) {
            echo "- Split Name: " . $split['name'] . ", Code: " . $split['split_code'] . ", Type: " . $split['type'] . "\n";
            if (!$splitId && $split['active']) { // Capture an active split ID if not already set
                $splitId = $split['id'];
                $splitCode = $split['split_code'];
            }
        }
    } else {
        echo "No active transaction splits found.\n";
    }
} catch (\Exception $e) {
    echo "Error listing transaction splits: " . $e->getMessage() . "\n";
}

// Ensure a split ID/code is available for fetch/update operations
if ($splitId || $splitCode) {
    $idToUse = $splitId ?: $splitCode; // Prefer ID if available, otherwise code

    // 3. Fetch details of a specific transaction split by ID or name
    try {
        $fetchedSplit = $client->transactionSplit()->fetch($idToUse);
        echo "\nFetched Transaction Split Details for '{$idToUse}':\n";
        print_r($fetchedSplit);
    } catch (\Exception $e) {
        echo "Error fetching transaction split '{$idToUse}': " . $e->getMessage() . "\n";
    }

    // 4. Update an existing transaction split (e.g., change name and deactivate)
    try {
        $updateSplitResponse = $client->transactionSplit()->update($idToUse, [
            'name' => 'Revised Team Payout Split',
            'active' => false, // Deactivate the split
        ]);
        echo "\nTransaction Split '{$idToUse}' Updated (and Deactivated):\n";
        print_r($updateSplitResponse);
    } catch (\Exception $e) {
        echo "Error updating transaction split: " . $e->getMessage() . "\n";
    }

    // Reactivate for further testing if needed
    try {
        $client->transactionSplit()->update($idToUse, ['active' => true]);
        echo "\nTransaction Split '{$idToUse}' Reactivated.\n";
    } catch (\Exception $e) {
        echo "Error reactivating transaction split: " . $e->getMessage() . "\n";
    }

    // 5. Add a subaccount to an existing transaction split
    // You'll need a third subaccount code for this example.
    $subaccount3Code = 'ACCT_test_sub_3'; // Replace with a real subaccount code
    try {
        $addResponse = $client->transactionSplit()->addSubAccount($idToUse, [
            'subaccount' => $subaccount3Code,
            'share' => 10, // Add 10% share (if original was percentage split) or 10000 (if flat split)
        ]);
        echo "\nSubaccount '{$subaccount3Code}' Added to Split '{$idToUse}':\n";
        print_r($addResponse);
    } catch (\Exception $e) {
        echo "Error adding subaccount to split: " . $e->getMessage() . "\n";
    }

    // 6. Remove a subaccount from an existing transaction split
    try {
        $removeResponse = $client->transactionSplit()->removeSubAccount($idToUse, [
            'subaccount' => $subaccount3Code,
        ]);
        echo "\nSubaccount '{$subaccount3Code}' Removed from Split '{$idToToUse}':\n";
        print_r($removeResponse);
    } catch (\Exception $e) {
        echo "Error removing subaccount from split: " . $e->getMessage() . "\n";
    }

} else {
    echo "\nSkipping split-specific operations as no valid split ID/code was obtained from creation.\n";
}

?>