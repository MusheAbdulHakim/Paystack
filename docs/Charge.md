### `Charge`

This class provides methods to directly charge a customer using various authentication methods (e.g., card details, authorization codes) and to handle subsequent authentication steps like PIN, OTP, phone, birthday, or address submissions. It also allows checking the status of a pending charge.

| Method Name | Description | Parameters | Return Type | Example Usage |
|---|---|---|---|---|
| `create` | Initiates a charge transaction. This can be done with card details, an authorization code, or a token. | `string $email`: Customer's email address. <br> `string $amount`: Amount in kobo. <br> `array $params = []`: Additional parameters like `authorization_code`, `card[number]`, `card[cvv]`, `card[expiry_month]`, `card[expiry_year]`, `bank_code`, `mobile_money_channel`, `metadata`, etc. | `array|string` | ```php $client->charge()->create('customer@example.com', '500000', ['authorization_code' => 'AUTH_xxxx']); ``` |
| `submitPin` | Submits a PIN for a pending charge that requires PIN authentication. | `string $pin`: The PIN provided by the customer. <br> `string $reference`: The transaction reference for the pending charge. | `array|string` | ```php $client->charge()->submitPin('1234', 'transaction_ref_abc'); ``` |
| `submitOTP` | Submits an OTP (One-Time Password) for a pending charge that requires OTP authentication. | `string $otp`: The OTP provided by the customer. <br> `string $reference`: The transaction reference for the pending charge. | `array|string` | ```php $client->charge()->submitOTP('987654', 'transaction_ref_abc'); ``` |
| `submitPhone` | Submits a phone number for a pending charge that requires phone authentication (e.g., for mobile money). | `string $phone`: The customer's phone number. <br> `string $reference`: The transaction reference for the pending charge. | `array|string` | ```php $client->charge()->submitPhone('+2348012345678', 'transaction_ref_abc'); ``` |
| `submitBirthday` | Submits a customer's birthday for a pending charge that requires birthday authentication. | `string $birthday`: The customer's birthday in `YYYY-MM-DD` format. <br> `string $reference`: The transaction reference for the pending charge. | `array|string` | ```php $client->charge()->submitBirthday('1990-01-15', 'transaction_ref_abc'); ``` |
| `submitAddress` | Submits address details for a pending charge that requires address verification (AVS). | `array $params = []`: An array containing address details (e.g., `reference`, `address`, `city`, `state`, `zipcode`). | `array|string` | ```php $client->charge()->submitAddress(['reference' => 'transaction_ref_abc', 'address' => '123 Main St', 'city' => 'Lagos', 'state' => 'Lagos', 'zipcode' => '100001']); ``` |
| `checkPending` | Checks the status of a pending charge. | `string $reference`: The transaction reference of the pending charge. | `array|string` | ```php $client->charge()->checkPending('transaction_ref_abc'); ``` |

**Usage and Sample Code:**

To use the `Charge` class, you first need to initialize the Paystack client with your secret key. Once the client is initialized, you can access the `charge()` method to interact with the Charge API.

```php
<?php

require 'vendor/autoload.php';

use MusheAbdulHakim\Paystack\Paystack;

// Replace with your actual Paystack secret key
$secretKey = 'sk_test_xxxxxxxxxxxxxxxxxxxxxxxxxxxx';

// Initialize the Paystack client
$client = Paystack::client($secretKey);

// --- Sample Usage for Charge Class ---

// Scenario 1: Charge using an existing authorization code
// This is common for recurring payments after a customer has made an initial payment.
try {
    $chargeResponse = $client->charge()->create(
        'customer@example.com',
        '500000', // Amount in kobo (e.g., NGN 5000.00)
        [
            'authorization_code' => 'AUTH_xxxxxxxxxxxxxxx', // Replace with a valid authorization code
            'reference' => 'my_app_charge_ref_001', // Optional: Your unique transaction reference
            'metadata' => ['order_id' => 'ORD-2023-001'],
        ]
    );

    echo "Charge using authorization code initiated:\n";
    print_r($chargeResponse);

    if ($chargeResponse['status'] === true && $chargeResponse['data']['status'] === 'success') {
        echo "Charge successful!\n";
    } else {
        echo "Charge failed or requires further action.\n";
        // Check $chargeResponse['data']['status'] and $chargeResponse['data']['gateway_response']
        // for details on why it failed or what action is needed (e.g., 'send_otp', 'send_pin').
    }

} catch (\Exception $e) {
    echo "Error initiating charge with authorization code: " . $e->getMessage() . "\n";
}

// Scenario 2: Simulate a charge that requires PIN submission
// In a real application, you would collect card details from the frontend,
// then initiate the charge. If a PIN is required, Paystack will return
// a 'send_pin' status, and you'd then prompt the user for their PIN.
echo "\n--- Simulating Charge requiring PIN ---\n";
$pendingChargeReference = 'pending_charge_ref_pin_123'; // This would come from the initial charge response

// Simulate initial charge response that requires PIN
$mockInitialChargeResponse = [
    'status' => true,
    'message' => 'Charge attempted',
    'data' => [
        'status' => 'send_pin',
        'reference' => $pendingChargeReference,
        'display_text' => 'Enter your card PIN to complete the transaction.',
        // ... other data from initial charge
    ],
];
echo "Mock Initial Charge Response (requires PIN):\n";
print_r($mockInitialChargeResponse);

if (isset($mockInitialChargeResponse['data']['status']) && $mockInitialChargeResponse['data']['status'] === 'send_pin') {
    $transactionReference = $mockInitialChargeResponse['data']['reference'];
    $userProvidedPin = '1234'; // In a real app, this comes from user input

    try {
        $submitPinResponse = $client->charge()->submitPin($userProvidedPin, $transactionReference);
        echo "\nPIN submission response:\n";
        print_r($submitPinResponse);

        if ($submitPinResponse['status'] === true && $submitPinResponse['data']['status'] === 'success') {
            echo "PIN submitted successfully and charge completed!\n";
        } else {
            echo "PIN submission failed or requires further action: " . ($submitPinResponse['data']['gateway_response'] ?? 'Unknown') . "\n";
        }
    } catch (\Exception $e) {
        echo "Error submitting PIN: " . $e->getMessage() . "\n";
    }
}

// Scenario 3: Simulate a charge that requires OTP submission
// Similar to PIN, if OTP is required, you'd prompt the user for the OTP sent to their phone.
echo "\n--- Simulating Charge requiring OTP ---\n";
$pendingChargeReferenceOtp = 'pending_charge_ref_otp_456';

// Simulate initial charge response that requires OTP
$mockInitialChargeResponseOtp = [
    'status' => true,
    'message' => 'Charge attempted',
    'data' => [
        'status' => 'send_otp',
        'reference' => $pendingChargeReferenceOtp,
        'display_text' => 'Enter the OTP sent to your phone.',
        // ... other data
    ],
];
echo "Mock Initial Charge Response (requires OTP):\n";
print_r($mockInitialChargeResponseOtp);

if (isset($mockInitialChargeResponseOtp['data']['status']) && $mockInitialChargeResponseOtp['data']['status'] === 'send_otp') {
    $transactionReference = $mockInitialChargeResponseOtp['data']['reference'];
    $userProvidedOtp = '654321'; // In a real app, this comes from user input

    try {
        $submitOtpResponse = $client->charge()->submitOTP($userProvidedOtp, $transactionReference);
        echo "\nOTP submission response:\n";
        print_r($submitOtpResponse);

        if ($submitOtpResponse['status'] === true && $submitOtpResponse['data']['status'] === 'success') {
            echo "OTP submitted successfully and charge completed!\n";
        } else {
            echo "OTP submission failed or requires further action: " . ($submitOtpResponse['data']['gateway_response'] ?? 'Unknown') . "\n";
        }
    } catch (\Exception $e) {
        echo "Error submitting OTP: " . $e->getMessage() . "\n";
    }
}

// Scenario 4: Check the status of a pending charge
// Useful for polling the status of a charge that is undergoing authentication.
echo "\n--- Checking Pending Charge Status ---\n";
$knownPendingReference = 'some_known_pending_reference_789'; // Replace with an actual pending reference

try {
    $checkStatusResponse = $client->charge()->checkPending($knownPendingReference);
    echo "\nStatus of pending charge '{$knownPendingReference}':\n";
    print_r($checkStatusResponse);
    if ($checkStatusResponse['status'] === true && $checkStatusResponse['data']['status'] === 'pending') {
        echo "Charge is still pending, waiting for user action.\n";
    } elseif ($checkStatusResponse['status'] === true && $checkStatusResponse['data']['status'] === 'success') {
        echo "Charge has now completed successfully.\n";
    } else {
        echo "Charge status: " . ($checkStatusResponse['data']['status'] ?? 'Unknown') . "\n";
    }
} catch (\Exception $e) {
    echo "Error checking pending charge status: " . $e->getMessage() . "\n";
}

// Other submission methods (submitPhone, submitBirthday, submitAddress)
// follow a similar pattern:
// 1. Initial charge returns a status requiring that specific info.
// 2. You extract the reference from the initial response.
// 3. You call the respective submit method with the user-provided data and the reference.

?>