### `MusheAbdulHakim\Paystack\Api\Verification`

This class provides methods for verifying and resolving financial details such as bank accounts and card numbers using Paystack's verification services. These are crucial for ensuring the accuracy of customer data and preventing fraud.

| Method Name | Description | Parameters | Return Type | Example Usage |
|---|---|---|---|---|
| `resolveAccount` | Resolves a bank account number to retrieve the account name associated with it. This helps confirm the account holder's identity. | `string $account_number`: The bank account number. <br> `string $bank_code`: The bank code (e.g., `'044'` for GTBank). | `array|string` | ```php $client->verification()->resolveAccount('0001234567', '044'); ``` |
| `validateAccount` | Validates a bank account number with additional details like account name, account type, and country. This is a more comprehensive validation than `resolveAccount`. | `array $params`: An array containing validation details: <br> - `account_number` (string, required): The bank account number. <br> - `bank_code` (string, required): The bank code. <br> - `account_name` (string, required): The expected name of the account holder. <br> - `account_type` (string, optional, e.g., `'personal'`, `'company'`). <br> - `country_code` (string, optional, default: `'NG'`): Country ISO code. | `array|string` | ```php $client->verification()->validateAccount(['account_number' => '0001234567', 'bank_code' => '044', 'account_name' => 'John Doe', 'country_code' => 'NG']); ``` |
| `resolveCard` | Resolves a card BIN (Bank Identification Number) to retrieve details about the card's issuer, type, and country. This is useful for pre-validating card inputs. | `string $bin`: The first 6 or 8 digits of a card number (BIN). | `array|string` | ```php $client->verification()->resolveCard('408408'); ``` |

**Usage and Sample Code:**

To use the `Verification` class, you first need to initialize the Paystack client with your secret key. Once the client is initialized, you can access the `verification()` method to interact with the Verification API.

```php
<?php

require 'vendor/autoload.php';

use MusheAbdulHakim\Paystack\Paystack;

// Replace with your actual Paystack secret key
$secretKey = 'sk_test_xxxxxxxxxxxxxxxxxxxxxxxxxxxx';

// Initialize the Paystack client
$client = Paystack::client($secretKey);

// --- Sample Usage for Verification Class ---

// 1. Resolve a bank account number
// This is commonly used to confirm the account name before initiating a transfer.
$accountNumberToResolve = '0001234567'; // Replace with a real account number for testing
$bankCodeToResolve = '044'; // GTBank (replace with a real bank code)
try {
    $resolvedAccount = $client->verification()->resolveAccount($accountNumberToResolve, $bankCodeToResolve);
    echo "Resolved Account for '{$accountNumberToResolve}' at Bank Code '{$bankCodeToResolve}':\n";
    print_r($resolvedAccount);
    if ($resolvedAccount['status'] === true && isset($resolvedAccount['data']['account_name'])) {
        echo "Account Name: " . $resolvedAccount['data']['account_name'] . "\n";
    }
} catch (\Exception $e) {
    echo "Error resolving account: " . $e->getMessage() . "\n";
}

// 2. Validate a bank account (more comprehensive check)
// This requires the expected account name for validation.
$accountNumberToValidate = '0001234567'; // Same account number as above
$bankCodeToValidate = '044'; // Same bank code
$expectedAccountName = 'John Doe'; // Replace with the actual expected account name
try {
    $validateAccountParams = [
        'account_number' => $accountNumberToValidate,
        'bank_code' => $bankCodeToValidate,
        'account_name' => $expectedAccountName,
        'account_type' => 'personal', // Optional
        'country_code' => 'NG', // Optional, defaults to NG
    ];
    $validatedAccount = $client->verification()->validateAccount($validateAccountParams);
    echo "\nValidated Account for '{$accountNumberToValidate}':\n";
    print_r($validatedAccount);
    if ($validatedAccount['status'] === true && $validatedAccount['data']['validation_status'] === 'valid') {
        echo "Account validation successful.\n";
    } else {
        echo "Account validation failed or is inconclusive.\n";
    }
} catch (\Exception $e) {
    echo "Error validating account: " . $e->getMessage() . "\n";
}

// 3. Resolve a card BIN (Bank Identification Number)
// This provides information about the card issuer, type, etc.
$cardBin = '408408'; // Example BIN for Visa
try {
    $resolvedCard = $client->verification()->resolveCard($cardBin);
    echo "\nResolved Card BIN '{$cardBin}':\n";
    print_r($resolvedCard);
    if ($resolvedCard['status'] === true && isset($resolvedCard['data']['brand'])) {
        echo "Card Brand: " . $resolvedCard['data']['brand'] . ", Card Type: " . $resolvedCard['data']['card_type'] . ", Country: " . $resolvedCard['data']['country_name'] . "\n";
    }
} catch (\Exception $e) {
    echo "Error resolving card BIN: " . $e->getMessage() . "\n";
}

?>