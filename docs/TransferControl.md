### `TransferControl`

This class provides methods to control various aspects of transfers and retrieve financial information related to your Paystack balance. It allows you to check your available balance, view the balance ledger, and manage OTP settings for transfers.

| Method Name | Description | Parameters | Return Type | Example Usage |
|---|---|---|---|---|
| `balance` | Retrieves the current balance of your Paystack account. | None | `array|string` | ```php $client->transferControl()->balance(); ``` |
| `ledger` | Retrieves the balance ledger, showing a detailed breakdown of your Paystack account balance. | None | `array|string` | ```php $client->transferControl()->ledger(); ``` |
| `resendOTP` | Resends the One-Time Password (OTP) for a pending transfer that requires OTP authentication. | `string $transfer_code`: The transfer code of the pending transfer. <br> `string $reason`: The reason for resending the OTP (e.g., `'resend_otp'`). | `array|string` | ```php $client->transferControl()->resendOTP('TRF_xxxx', 'resend_otp'); ``` |
| `disableOTP` | Initiates the process to disable OTP requirement for transfers on your account. This usually requires a finalization step with an OTP. | None | `array|string` | ```php $client->transferControl()->disableOTP(); ``` |
| `finalizeDisableOTP` | Completes the process of disabling OTP for transfers by providing the OTP sent to your registered phone number. | `string $otp`: The OTP received to finalize disabling. | `array|string` | ```php $client->transferControl()->finalizeDisableOTP('123456'); ``` |
| `enableOTP` | Enables OTP requirement for transfers on your account. | None | `array|string` | ```php $client->transferControl()->enableOTP(); ``` |

**Usage and Sample Code:**

To use the `TransferControl` class, you first need to initialize the Paystack client with your secret key. Once the client is initialized, you can access the `transferControl()` method to interact with the Transfer Control API.

```php
<?php

require 'vendor/autoload.php';

use MusheAbdulHakim\Paystack\Paystack;

// Replace with your actual Paystack secret key
$secretKey = 'sk_test_xxxxxxxxxxxxxxxxxxxxxxxxxxxx';

// Initialize the Paystack client
$client = Paystack::client($secretKey);

// --- Sample Usage for TransferControl Class ---

// 1. Retrieve your current Paystack balance
try {
    $balanceResponse = $client->transferControl()->balance();
    echo "Current Paystack Balance:\n";
    print_r($balanceResponse);
    if (isset($balanceResponse['data'][0]['currency']) && isset($balanceResponse['data'][0]['balance'])) {
        echo "Your " . $balanceResponse['data'][0]['currency'] . " balance is: " . ($balanceResponse['data'][0]['balance'] / 100) . "\n";
    }
} catch (\Exception $e) {
    echo "Error fetching balance: " . $e->getMessage() . "\n";
}

// 2. Retrieve your balance ledger (detailed breakdown)
try {
    $ledgerResponse = $client->transferControl()->ledger();
    echo "\nPaystack Balance Ledger:\n";
    print_r($ledgerResponse);
} catch (\Exception $e) {
    echo "Error fetching ledger: " . $e->getMessage() . "\n";
}

// Note: The OTP management functions (resendOTP, disableOTP, finalizeDisableOTP, enableOTP)
// interact with sensitive account security settings. Use them with caution and
// understand their implications for your account.
// For testing, you would need a scenario where a transfer is pending OTP.

// Let's assume you have a pending transfer code that requires OTP
$pendingTransferCode = 'TRF_test_pending_otp'; // Replace with an actual pending transfer code

// 3. Resend OTP for a pending transfer
if ($pendingTransferCode) {
    try {
        $resendOtpResponse = $client->transferControl()->resendOTP($pendingTransferCode, 'resend_otp');
        echo "\nResend OTP for Transfer '{$pendingTransferCode}':\n";
        print_r($resendOtpResponse);
    } catch (\Exception $e) {
        echo "Error resending OTP: " . $e->getMessage() . "\n";
    }
} else {
    echo "\nSkipping resend OTP as no pending transfer code is available.\n";
}

// 4. Disable OTP for transfers (Initiate)
// This will send an OTP to your registered phone number to confirm the disable action.
try {
    $disableOtpInitiateResponse = $client->transferControl()->disableOTP();
    echo "\nInitiate Disable OTP Response:\n";
    print_r($disableOtpInitiateResponse);
    $disableOtpToken = $disableOtpInitiateResponse['data']['otp_token'] ?? null; // This token is often needed for finalize
    echo "An OTP has been sent to your registered phone number. Please check your phone.\n";
} catch (\Exception $e) {
    echo "Error initiating disable OTP: " . $e->getMessage() . "\n";
    $disableOtpToken = null;
}

// 5. Finalize Disable OTP (requires the OTP received)
// In a real application, you'd prompt the user for the OTP.
if ($disableOtpToken) {
    $userProvidedDisableOtp = '987654'; // Replace with the actual OTP received on your phone
    try {
        $finalizeDisableOtpResponse = $client->transferControl()->finalizeDisableOTP($userProvidedDisableOtp);
        echo "\nFinalize Disable OTP Response:\n";
        print_r($finalizeDisableOtpResponse);
        if ($finalizeDisableOtpResponse['status'] === true && $finalizeDisableOtpResponse['message'] === 'OTP successfully disabled') {
            echo "OTP for transfers successfully disabled.\n";
        }
    } catch (\Exception $e) {
        echo "Error finalizing disable OTP: " . $e->getMessage() . "\n";
    }
} else {
    echo "\nSkipping finalize disable OTP as no OTP token was obtained.\n";
}

// 6. Enable OTP for transfers
// This will re-enable OTP requirement for transfers on your account.
try {
    $enableOtpResponse = $client->transferControl()->enableOTP();
    echo "\nEnable OTP Response:\n";
    print_r($enableOtpResponse);
    if ($enableOtpResponse['status'] === true && $enableOtpResponse['message'] === 'OTP successfully enabled') {
        echo "OTP for transfers successfully enabled.\n";
    }
} catch (\Exception $e) {
    echo "Error enabling OTP: " . $e->getMessage() . "\n";
}

?>