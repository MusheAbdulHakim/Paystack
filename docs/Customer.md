### `Customer`

This class provides comprehensive methods to manage customer records on Paystack. You can create, list, fetch, update, and validate customer details. It also offers functionalities to manage customer risk actions (blacklist/whitelist) and deactivate specific authorizations.

| Method Name | Description | Parameters | Return Type | Example Usage |
|---|---|---|---|---|
| `create` | Creates a new customer on your Paystack account. | `array $params`: An array of customer details (e.g., `email`, `first_name`, `last_name`, `phone`, `metadata`). | `array|string` | ```php $client->customer()->create(['email' => 'jane.doe@example.com', 'first_name' => 'Jane', 'last_name' => 'Doe', 'phone' => '+2348012345678']); ``` |
| `list` | Retrieves a list of all customers on your Paystack account. | `array $params = []`: Optional query parameters for filtering or pagination (e.g., `perPage`, `page`, `from`, `to`). | `array|string` | ```php $client->customer()->list(['perPage' => 10, 'page' => 2]); ``` |
| `fetch` | Fetches the details of a specific customer using their email address or customer code. | `string $emailOrCode`: The email address or customer code of the customer. | `array|string` | ```php $client->customer()->fetch('jane.doe@example.com'); ``` |
| `update` | Updates the details of an existing customer. | `string $code`: The customer code of the customer to update. <br> `array $params = []`: An array of parameters to update (e.g., `first_name`, `last_name`, `phone`, `metadata`). | `array|string` | ```php $client->customer()->update('CUS_xxxx', ['phone' => '+2349098765432']); ``` |
| `validate` | Validates a customer's identity using various methods like BVN. | `string $code`: The customer code of the customer to validate. <br> `array $params = []`: An array containing identification details (e.g., `country`, `type` (e.g., 'bvn'), `value` (e.g., BVN number), `bvn`, `bank_code`, `account_number`). | `array|string` | ```php $client->customer()->validate('CUS_xxxx', ['country' => 'NG', 'type' => 'bvn', 'value' => '12345678901']); ``` |
| `status` | Sets the risk action for a customer, either allowing or denying transactions. | `string $customer`: The customer email or customer code. <br> `string $action`: The risk action to set (`'allow'` or `'deny'`). | `array|string` | ```php $client->customer()->status('CUS_xxxx', 'deny'); ``` |
| `blackList` | Blacklists a customer, preventing them from making transactions. This is a convenience method for `status('deny')`. | `string $customer`: The customer email or customer code to blacklist. | `array|string` | ```php $client->customer()->blackList('customer@example.com'); ``` |
| `whiteList` | Whitelists a customer, allowing them to make transactions. This is a convenience method for `status('allow')`. | `string $customer`: The customer email or customer code to whitelist. | `array|string` | ```php $client->customer()->whiteList('customer@example.com'); ``` |
| `deactivate` | Deactivates a specific authorization code for a customer. This invalidates a saved card token. | `string $code`: The authorization code to deactivate. | `array|string` | ```php $client->customer()->deactivate('AUTH_xxxx'); ``` |

**Usage and Sample Code:**

To use the `Customer` class, you first need to initialize the Paystack client with your secret key. Once the client is initialized, you can access the `customer()` method to interact with the Customer API.

```php
<?php

require 'vendor/autoload.php';

use MusheAbdulHakim\Paystack\Paystack;

// Replace with your actual Paystack secret key
$secretKey = 'sk_test_xxxxxxxxxxxxxxxxxxxxxxxxxxxx';

// Initialize the Paystack client
$client = Paystack::client($secretKey);

// --- Sample Usage for Customer Class ---

// 1. Create a new customer
try {
    $newCustomer = $client->customer()->create([
        'email' => 'test_user_' . uniqid() . '@example.com', // Use unique email for testing
        'first_name' => 'John',
        'last_name' => 'Doe',
        'phone' => '+2348012345678',
        'metadata' => ['source' => 'web_signup'],
    ]);
    echo "New Customer Created:\n";
    print_r($newCustomer);
    $customerCode = $newCustomer['data']['customer_code'] ?? null;
    $customerEmail = $newCustomer['data']['email'] ?? null;
} catch (\Exception $e) {
    echo "Error creating customer: " . $e->getMessage() . "\n";
    $customerCode = null;
    $customerEmail = null;
}

// Ensure a customer was created or use a known customer for subsequent operations
if ($customerCode) {
    // 2. Fetch customer details by customer code
    try {
        $fetchedCustomer = $client->customer()->fetch($customerCode);
        echo "\nFetched Customer by Code ('{$customerCode}'):\n";
        print_r($fetchedCustomer);
    } catch (\Exception $e) {
        echo "Error fetching customer by code: " . $e->getMessage() . "\n";
    }

    // 3. Fetch customer details by email
    if ($customerEmail) {
        try {
            $fetchedCustomerByEmail = $client->customer()->fetch($customerEmail);
            echo "\nFetched Customer by Email ('{$customerEmail}'):\n";
            print_r($fetchedCustomerByEmail);
        } catch (\Exception $e) {
            echo "Error fetching customer by email: " . $e->getMessage() . "\n";
        }
    }

    // 4. Update customer details
    try {
        $updatedCustomer = $client->customer()->update($customerCode, [
            'first_name' => 'Jonathan',
            'last_name' => 'Doe-Smith',
        ]);
        echo "\nCustomer Updated:\n";
        print_r($updatedCustomer);
    } catch (\Exception $e) {
        echo "Error updating customer: " . $e->getMessage() . "\n";
    }

    // 5. Validate customer identity (e.g., with BVN)
    // Note: For real validation, you need actual BVN/account details.
    // This is a mock example.
    try {
        $validationParams = [
            'country' => 'NG',
            'type' => 'bvn',
            'value' => '12345678901', // Replace with a real BVN for actual validation
            // 'bvn' => '12345678901', // Alternative for BVN
            // 'bank_code' => '044',
            // 'account_number' => '0123456789',
        ];
        $validationResponse = $client->customer()->validate($customerCode, $validationParams);
        echo "\nCustomer Validation Response:\n";
        print_r($validationResponse);
    } catch (\Exception $e) {
        echo "Error validating customer: " . $e->getMessage() . "\n";
    }

    // 6. Blacklist a customer (deny risk action)
    try {
        $blacklistResponse = $client->customer()->blackList($customerCode);
        echo "\nCustomer Blacklisted:\n";
        print_r($blacklistResponse);
    } catch (\Exception $e) {
        echo "Error blacklisting customer: " . $e->getMessage() . "\n";
    }

    // 7. Whitelist a customer (allow risk action)
    // This assumes the customer was previously blacklisted or set to 'deny'.
    try {
        $whitelistResponse = $client->customer()->whiteList($customerCode);
        echo "\nCustomer Whitelisted:\n";
        print_r($whitelistResponse);
    } catch (\Exception $e) {
        echo "Error whitelisting customer: " . $e->getMessage() . "\n";
    }

} else {
    echo "\nSkipping customer-specific operations as no customer code was obtained.\n";
}

// 8. List all customers (with pagination example)
try {
    $allCustomers = $client->customer()->list(['perPage' => 3, 'page' => 1]);
    echo "\nListing Customers (first 3):\n";
    print_r($allCustomers);
} catch (\Exception $e) {
    echo "Error listing customers: " . $e->getMessage() . "\n";
}

// 9. Deactivate an authorization (requires an actual authorization code)
// This is used to invalidate a saved card token for a customer.
// You would typically get this authorization code from a successful transaction.
$sampleAuthorizationCode = 'AUTH_abcdefghijk'; // Replace with a real authorization code
try {
    $deactivateAuthResponse = $client->customer()->deactivate($sampleAuthorizationCode);
    echo "\nAuthorization '{$sampleAuthorizationCode}' Deactivated:\n";
    print_r($deactivateAuthResponse);
} catch (\Exception $e) {
    echo "Error deactivating authorization '{$sampleAuthorizationCode}': " . $e->getMessage() . "\n";
}

?>