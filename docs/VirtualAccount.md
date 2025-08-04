### `MusheAbdulHakim\Paystack\Api\VirtualAccount`

This class provides methods to interact with the Paystack Virtual Account API, also referred to as Dedicated Accounts. Virtual accounts allow you to provide unique bank account numbers to your customers for easier and more traceable payments. You can create, assign, list, fetch, requery, deactivate virtual accounts, manage transaction splits on them, and retrieve available bank providers.

| Method Name | Description | Parameters | Return Type | Example Usage |
|---|---|---|---|---|
| `create` | Creates a new dedicated virtual account for a customer. | `array $params`: An array of parameters for the virtual account: <br> - `customer` (string, required): Customer ID or email. <br> - `preferred_bank` (string, optional): Slug of the preferred bank for the virtual account (e.g., `'wema-bank'`, `'providus-bank'`). <br> - `split_code` (string, optional): The split code to apply to transactions on this virtual account. | `array|string` | ```php $client->virtualAccount()->create(['customer' => 'CUS_xxxx', 'preferred_bank' => 'wema-bank']); ``` |
| `assign` | Assigns an existing dedicated virtual account to a customer. This is useful if you manually create virtual accounts outside Paystack and want to link them. | `array $params`: An array containing: <br> - `customer` (string, required): Customer ID or email. <br> - `account_number` (string, required): The dedicated account number. <br> - `bank_slug` (string, required): The slug of the bank providing the dedicated account. | `array|string` | ```php $client->virtualAccount()->assign(['customer' => 'CUS_xxxx', 'account_number' => '9012345678', 'bank_slug' => 'wema-bank']); ``` |
| `list` | Lists all dedicated virtual accounts on your Paystack account. | `array $params = []`: Optional query parameters for filtering or pagination: <br> - `perPage` (int) <br> - `page` (int) <br> - `customer` (string, customer ID or email) <br> - `bank_id` (int, filter by bank ID) <br> - `active` (bool, filter by active status) | `array|string` | ```php $client->virtualAccount()->list(['customer' => 'CUS_xxxx', 'active' => true]); ``` |
| `fetch` | Fetches the details of a specific dedicated virtual account using its ID. | `string $id`: The ID of the dedicated virtual account. | `array|string` | ```php $client->virtualAccount()->fetch('dedicated_account_xxxx'); ``` |
| `requery` | Requeries a dedicated virtual account to get its latest status and details. | `array $params`: An array containing: <br> - `account_number` (string, required): The dedicated account number. <br> - `provider_slug` (string, required): The slug of the bank provider. | `array|string` | ```php $client->virtualAccount()->requery(['account_number' => '9012345678', 'provider_slug' => 'wema-bank']); ``` |
| `deactivate` | Deactivates a dedicated virtual account. Once deactivated, it can no longer receive payments. | `string $id`: The ID of the dedicated virtual account to deactivate. | `array|string` | ```php $client->virtualAccount()->deactivate('dedicated_account_xxxx'); ``` |
| `splitTransaction` | Sets up a transaction split for a dedicated virtual account. Payments made to this account will automatically be split according to the specified split code. | `string $customer`: The customer ID or email associated with the virtual account. <br> `array $params`: An array containing: <br> - `split_code` (string, required): The split code to apply. | `array|string` | ```php $client->virtualAccount()->splitTransaction('CUS_xxxx', ['split_code' => 'SPL_yyyy']); ``` |
| `removeSplit` | Removes a transaction split from a dedicated virtual account. | `string $account`: The account number of the dedicated virtual account. | `array|string` | ```php $client->virtualAccount()->removeSplit('9012345678'); ``` |
| `bankProviders` | Retrieves a list of available bank providers for dedicated virtual accounts. | None | `array|string` | ```php $client->virtualAccount()->bankProviders(); ``` |

**Usage and Sample Code:**

To use the `VirtualAccount` class, you first need to initialize the Paystack client with your secret key. Once the client is initialized, you can access the `virtualAccount()` method to interact with the Virtual Account API.

```php
<?php

require 'vendor/autoload.php';

use MusheAbdulHakim\Paystack\Paystack;

// Replace with your actual Paystack secret key
$secretKey = 'sk_test_xxxxxxxxxxxxxxxxxxxxxxxxxxxx';

// Initialize the Paystack client
$client = Paystack::client($secretKey);

// --- Sample Usage for VirtualAccount Class ---

// Prerequisites:
// You need an existing customer to create/assign a virtual account.
// If you don't have one, create it first using the Customer API.
$sampleCustomerCode = 'CUS_test_customer'; // Replace with a real customer code or email
$sampleSplitCode = 'SPL_test_split'; // Replace with a real transaction split code if testing split features

// 1. Get available bank providers for virtual accounts
try {
    $bankProviders = $client->virtualAccount()->bankProviders();
    echo "Available Bank Providers for Virtual Accounts:\n";
    print_r($bankProviders);
    $preferredBankSlug = $bankProviders['data'][0]['slug'] ?? 'wema-bank'; // Use first available or default
    echo "Using preferred bank slug: {$preferredBankSlug}\n";
} catch (\Exception $e) {
    echo "Error fetching bank providers: " . $e->getMessage() . "\n";
    $preferredBankSlug = 'wema-bank'; // Fallback
}


// 2. Create a new dedicated virtual account for a customer
try {
    $createVirtualAccountResponse = $client->virtualAccount()->create([
        'customer' => $sampleCustomerCode,
        'preferred_bank' => $preferredBankSlug,
        // 'split_code' => $sampleSplitCode, // Uncomment to apply a split at creation
    ]);
    echo "\nNew Virtual Account Created:\n";
    print_r($createVirtualAccountResponse);
    $virtualAccountId = $createVirtualAccountResponse['data']['id'] ?? null;
    $virtualAccountNumber = $createVirtualAccountResponse['data']['account_number'] ?? null;
    $virtualAccountBankSlug = $createVirtualAccountResponse['data']['bank']['slug'] ?? null;
} catch (\Exception $e) {
    echo "Error creating virtual account: " . $e->getMessage() . "\n";
    $virtualAccountId = null;
    $virtualAccountNumber = null;
    $virtualAccountBankSlug = null;
}

// 3. Assign an existing dedicated virtual account to a customer (if you have one)
// This is for cases where the virtual account is already created and you want to link it.
$existingAccountNumber = '9000000000'; // Replace with an actual existing virtual account number
$existingBankSlug = 'providus-bank'; // Replace with the bank slug for that account
try {
    $assignResponse = $client->virtualAccount()->assign([
        'customer' => $sampleCustomerCode,
        'account_number' => $existingAccountNumber,
        'bank_slug' => $existingBankSlug,
    ]);
    echo "\nAssigned Virtual Account '{$existingAccountNumber}' to Customer '{$sampleCustomerCode}':\n";
    print_r($assignResponse);
} catch (\Exception $e) {
    echo "Error assigning virtual account: " . $e->getMessage() . "\n";
}


// 4. List all dedicated virtual accounts
try {
    $allVirtualAccounts = $client->virtualAccount()->list(['perPage' => 5, 'customer' => $sampleCustomerCode]);
    echo "\nListing Virtual Accounts for Customer '{$sampleCustomerCode}' (first 5):\n";
    if (!empty($allVirtualAccounts['data'])) {
        foreach ($allVirtualAccounts['data'] as $va) {
            echo "- Account Number: " . $va['account_number'] . ", Bank: " . $va['bank']['name'] . ", Status: " . ($va['active'] ? 'Active' : 'Inactive') . "\n";
            // Capture an ID if not already set, for fetch/requery/deactivate
            if (!$virtualAccountId && $va['active']) {
                $virtualAccountId = $va['id'];
                $virtualAccountNumber = $va['account_number'];
                $virtualAccountBankSlug = $va['bank']['slug'];
            }
        }
    } else {
        echo "No virtual accounts found for this customer.\n";
    }
} catch (\Exception $e) {
    echo "Error listing virtual accounts: " . $e->getMessage() . "\n";
}

// Ensure a virtual account ID and number are available for subsequent operations
if ($virtualAccountId && $virtualAccountNumber && $virtualAccountBankSlug) {
    // 5. Fetch details of a specific dedicated virtual account
    try {
        $fetchedVirtualAccount = $client->virtualAccount()->fetch($virtualAccountId);
        echo "\nFetched Virtual Account Details for ID '{$virtualAccountId}':\n";
        print_r($fetchedVirtualAccount);
    } catch (\Exception $e) {
        echo "Error fetching virtual account '{$virtualAccountId}': " . $e->getMessage() . "\n";
    }

    // 6. Requery a dedicated virtual account for its status
    try {
        $requeryResponse = $client->virtualAccount()->requery([
            'account_number' => $virtualAccountNumber,
            'provider_slug' => $virtualAccountBankSlug,
        ]);
        echo "\nRequeried Virtual Account '{$virtualAccountNumber}':\n";
        print_r($requeryResponse);
    } catch (\Exception $e) {
        echo "Error requerying virtual account: " . $e->getMessage() . "\n";
    }

    // 7. Set up a transaction split for the virtual account
    if ($sampleSplitCode) {
        try {
            $setSplitResponse = $client->virtualAccount()->splitTransaction($sampleCustomerCode, [
                'split_code' => $sampleSplitCode,
            ]);
            echo "\nTransaction Split '{$sampleSplitCode}' Set for Virtual Account:\n";
            print_r($setSplitResponse);
        } catch (\Exception $e) {
            echo "Error setting transaction split for virtual account: " . $e->getMessage() . "\n";
        }

        // 8. Remove a transaction split from the virtual account
        try {
            $removeSplitResponse = $client->virtualAccount()->removeSplit($virtualAccountNumber);
            echo "\nTransaction Split Removed from Virtual Account '{$virtualAccountNumber}':\n";
            print_r($removeSplitResponse);
        } catch (\Exception $e) {
            echo "Error removing transaction split from virtual account: " . $e->getMessage() . "\n";
        }
    } else {
        echo "\nSkipping split operations for virtual account as no valid split code is available.\n";
    }

    // 9. Deactivate a dedicated virtual account
    // IMPORTANT: Deactivating is permanent and the account can no longer receive payments.
    try {
        $deactivateResponse = $client->virtualAccount()->deactivate($virtualAccountId);
        echo "\nVirtual Account '{$virtualAccountId}' Deactivated:\n";
        print_r($deactivateResponse);
    } catch (\Exception $e) {
        echo "Error deactivating virtual account: " . $e->getMessage() . "\n";
    }

} else {
    echo "\nSkipping virtual account-specific operations as no valid virtual account ID/number/bank slug was obtained.\n";
}

?>