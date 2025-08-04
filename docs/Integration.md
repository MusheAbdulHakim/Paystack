### `Integration`

This class provides methods to interact with the Paystack Integration API, primarily for managing your payment session timeout settings. This allows you to control how long a payment session remains active before expiring.

| Method Name | Description | Parameters | Return Type | Example Usage |
|---|---|---|---|---|
| `fetchPayment` | Fetches the current payment session timeout setting for your integration. | None | `array|string` | ```php $client->integration()->fetchPayment(); ``` |
| `updatePayment` | Updates the payment session timeout setting for your integration. | `int $timeout`: The new timeout value in minutes. Minimum value is 10 minutes, and the maximum is 120 minutes. | `array|string` | ```php $client->integration()->updatePayment(60); // Set timeout to 60 minutes ``` |

**Usage and Sample Code:**

To use the `Integration` class, you first need to initialize the Paystack client with your secret key. Once the client is initialized, you can access the `integration()` method to interact with the Integration API.

```php
<?php

require 'vendor/autoload.php';

use MusheAbdulHakim\Paystack\Paystack;

// Replace with your actual Paystack secret key
$secretKey = 'sk_test_xxxxxxxxxxxxxxxxxxxxxxxxxxxx';

// Initialize the Paystack client
$client = Paystack::client($secretKey);

// --- Sample Usage for Integration Class ---

// 1. Fetch the current payment session timeout
try {
    $timeoutResponse = $client->integration()->fetchPayment();
    echo "Current Payment Session Timeout:\n";
    print_r($timeoutResponse);
    if (isset($timeoutResponse['data']['timeout'])) {
        echo "The current payment session timeout is: " . $timeoutResponse['data']['timeout'] . " minutes.\n";
    }
} catch (\Exception $e) {
    echo "Error fetching payment session timeout: " . $e->getMessage() . "\n";
}

// 2. Update the payment session timeout
// Let's try to set the timeout to 30 minutes.
$newTimeout = 30; // Must be between 10 and 120 minutes
try {
    $updateResponse = $client->integration()->updatePayment($newTimeout);
    echo "\nUpdating Payment Session Timeout to {$newTimeout} minutes:\n";
    print_r($updateResponse);
    if ($updateResponse['status'] === true && $updateResponse['message'] === 'Payment session timeout updated') {
        echo "Payment session timeout successfully updated to {$newTimeout} minutes.\n";
    }
} catch (\Exception $e) {
    echo "Error updating payment session timeout: " . $e->getMessage() . "\n";
    // Paystack API might return errors if timeout is out of range or other issues.
}

// Verify the update by fetching again
try {
    $updatedTimeoutResponse = $client->integration()->fetchPayment();
    echo "\nVerified Payment Session Timeout after update:\n";
    print_r($updatedTimeoutResponse);
    if (isset($updatedTimeoutResponse['data']['timeout'])) {
        echo "The payment session timeout is now: " . $updatedTimeoutResponse['data']['timeout'] . " minutes.\n";
    }
} catch (\Exception $e) {
    echo "Error verifying updated payment session timeout: " . $e->getMessage() . "\n";
}

?>