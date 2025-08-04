### `SubAccount`

This class provides methods to interact with the Paystack Subaccount API. Subaccounts are used for marketplaces or platforms that need to split payments with other businesses or individuals. You can create, list, fetch, and update subaccounts.

| Method Name | Description | Parameters | Return Type | Example Usage |
|---|---|---|---|---|
| `create` | Creates a new subaccount. | `array $params`: An array of parameters for the subaccount: <br> - `business_name` (string, required): Name of the subaccount's business. <br> - `settlement_bank` (string, required): Bank code for settlements (e.g., `'044'` for GTBank). <br> - `account_number` (string, required): Bank account number for settlements. <br> - `percentage_charge` (float, required): The percentage of the transaction amount to be split to the subaccount. <br> - `description` (string, optional): A description for the subaccount. <br> - `primary_contact_email` (string, optional): Primary contact email. <br> - `primary_contact_name` (string, optional): Primary contact name. <br> - `primary_contact_phone` (string, optional): Primary contact phone. <br> - `settlement_schedule` (string, optional, default: `'auto'`): How often to settle (`'auto'`, `'daily'`, `'weekly'`, `'monthly'`). | `array|string` | ```php $client->subAccount()->create(['business_name' => 'Vendor Payments Ltd', 'settlement_bank' => '044', 'account_number' => '0123456789', 'percentage_charge' => 10.5, 'description' => 'Payouts for our vendors']); ``` |
| `list` | Lists all subaccounts on your Paystack account. | `array $params = []`: Optional query parameters for filtering or pagination: <br> - `perPage` (int) <br> - `page` (int) <br> - `from` (datetime) <br> - `to` (datetime) | `array|string` | ```php $client->subAccount()->list(['perPage' => 10]); ``` |
| `fetch` | Fetches the details of a specific subaccount using its ID or subaccount code. | `string $id`: The ID or unique code of the subaccount. | `array|string` | ```php $client->subAccount()->fetch('subacct_xxxx'); ``` |
| `update` | Updates the details of an existing subaccount. | `string $id`: The ID or unique code of the subaccount. <br> `array $params = []`: An array of parameters to update (e.g., `business_name`, `percentage_charge`, `description`, `active`). | `array|string` | ```php $client->subAccount()->update('subacct_xxxx', ['percentage_charge' => 12.0, 'active' => false]); ``` |

**Usage and Sample Code:**

To use the `SubAccount` class, you first need to initialize the Paystack client with your secret key. Once the client is initialized, you can access the `subAccount()` method to interact with the Subaccount API.

```php
<?php

require 'vendor/autoload.php';

use MusheAbdulHakim\Paystack\Paystack;

// Replace with your actual Paystack secret key
$secretKey = 'sk_test_xxxxxxxxxxxxxxxxxxxxxxxxxxxx';

// Initialize the Paystack client
$client = Paystack::client($secretKey);

// --- Sample Usage for SubAccount Class ---

// 1. Create a new subaccount
// For this to work, ensure the bank code and account number are valid for a real bank.
try {
    $subaccountName = 'My Partner Store ' . uniqid();
    $createSubAccountResponse = $client->subAccount()->create([
        'business_name' => $subaccountName,
        'settlement_bank' => '044', // GTBank
        'account_number' => '0123456789', // Replace with a valid account number for the bank
        'percentage_charge' => 15.0, // 15% of transaction
        'description' => 'Subaccount for partner store sales',
    ]);
    echo "New SubAccount Created:\n";
    print_r($createSubAccountResponse);
    $subaccountId = $createSubAccountResponse['data']['id'] ?? null;
    $subaccountCode = $createSubAccountResponse['data']['subaccount_code'] ?? null;
} catch (\Exception $e) {
    echo "Error creating subaccount: " . $e->getMessage() . "\n";
    $subaccountId = null;
    $subaccountCode = null;
}

// 2. List all subaccounts
try {
    $allSubAccounts = $client->subAccount()->list(['perPage' => 5]);
    echo "\nListing SubAccounts (first 5):\n";
    if (!empty($allSubAccounts['data'])) {
        foreach ($allSubAccounts['data'] as $subaccount) {
            echo "- Business Name: " . $subaccount['business_name'] . ", Code: " . $subaccount['subaccount_code'] . ", Percentage: " . $subaccount['percentage_charge'] . "%\n";
        }
    } else {
        echo "No subaccounts found.\n";
    }
} catch (\Exception $e) {
    echo "Error listing subaccounts: " . $e->getMessage() . "\n";
}

// Ensure a subaccount ID/code is available for fetch/update operations
if ($subaccountId || $subaccountCode) {
    $idToUse = $subaccountId ?: $subaccountCode; // Prefer ID if available, otherwise code

    // 3. Fetch details of a specific subaccount by ID or code
    try {
        $fetchedSubAccount = $client->subAccount()->fetch($idToUse);
        echo "\nFetched SubAccount Details for '{$idToUse}':\n";
        print_r($fetchedSubAccount);
    } catch (\Exception $e) {
        echo "Error fetching subaccount '{$idToUse}': " . $e->getMessage() . "\n";
    }

    // 4. Update an existing subaccount (e.g., change percentage charge)
    try {
        $updateSubAccountResponse = $client->subAccount()->update($idToUse, [
            'percentage_charge' => 12.5, // Update percentage to 12.5%
            'description' => 'Updated description for partner store sales',
        ]);
        echo "\nSubAccount '{$idToUse}' Updated:\n";
        print_r($updateSubAccountResponse);
    } catch (\Exception $e) {
        echo "Error updating subaccount: " . $e->getMessage() . "\n";
    }

} else {
    echo "\nSkipping subaccount-specific operations as no valid subaccount ID/code was obtained from creation.\n";
}

?>