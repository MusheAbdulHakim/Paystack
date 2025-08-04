### `Transfer`

This class provides methods to interact with the Paystack Transfer API. Transfers enable you to send money from your Paystack balance to bank accounts or mobile money wallets. You can initiate single transfers, bulk transfers, finalize transfers requiring OTP, list transfers, fetch details, and verify their status.

| Method Name | Description | Parameters | Return Type | Example Usage |
|---|---|---|---|---|
| `init` | Initiates a new single transfer. | `array $params`: An array of transfer details: <br> - `source` (string, required): Where the transfer is coming from (`'balance'`). <br> - `amount` (int, required): Amount to transfer in kobo. <br> - `recipient` (string, required): Recipient code (e.g., `'RCP_xxxx'`). <br> - `reason` (string, optional): Reason for the transfer. <br> - `currency` (string, optional, default: `'NGN'`): Currency of the transfer. | `array|string` | ```php $client->transfer()->init(['source' => 'balance', 'amount' => 500000, 'recipient' => 'RCP_xxxx', 'reason' => 'Monthly payout']); ``` |
| `finalize` | Finalizes a transfer that requires an OTP (One-Time Password) for completion. | `string $code`: The transfer code of the pending transfer. <br> `string $otp`: The OTP received by the merchant. | `array|string` | ```php $client->transfer()->finalize('TRF_xxxx', '123456'); ``` |
| `bulk` | Initiates multiple transfers in a single request. | `string $source`: Where the transfers are coming from (`'balance'`). <br> `array $transfers`: An array of individual transfer objects, each containing: <br> - `amount` (int, required): Amount to transfer in kobo. <br> - `recipient` (string, required): Recipient code. <br> - `reason` (string, optional): Reason for this specific transfer. | `array|string` | ```php $client->transfer()->bulk('balance', [['amount' => 100000, 'recipient' => 'RCP_yyyy'], ['amount' => 200000, 'recipient' => 'RCP_zzzz']]); ``` |
| `list` | Lists all transfers on your Paystack account. | `array $params = []`: Optional query parameters for filtering or pagination: <br> - `perPage` (int) <br> - `page` (int) <br> - `status` (string, e.g., `'success'`, `'pending'`, `'failed'`) <br> - `recipient` (string, recipient code) <br> - `from` (datetime) <br> - `to` (datetime) | `array|string` | ```php $client->transfer()->list(['status' => 'success', 'perPage' => 10]); ``` |
| `fetch` | Fetches the details of a specific transfer using its ID. | `string $id`: The ID of the transfer. | `array|string` | ```php $client->transfer()->fetch('TRF_xxxx'); ``` |
| `verify` | Verifies the status of a transfer using its reference. | `string $reference`: The unique transfer reference. | `array|string` | ```php $client->transfer()->verify('your_transfer_reference'); ``` |

**Usage and Sample Code:**

To use the `Transfer` class, you first need to initialize the Paystack client with your secret key. Once the client is initialized, you can access the `transfer()` method to interact with the Transfer API.

```php
<?php

require 'vendor/autoload.php';

use MusheAbdulHakim\Paystack\Paystack;

// Replace with your actual Paystack secret key
$secretKey = 'sk_test_xxxxxxxxxxxxxxxxxxxxxxxxxxxx';

// Initialize the Paystack client
$client = Paystack::client($secretKey);

// --- Sample Usage for Transfer Class ---

// Prerequisites:
// You need existing transfer recipients to perform transfers.
// If you don't have any, create them first using the TransferRecipient API.
// Example dummy recipient codes:
$recipient1Code = 'RCP_test_rec_1'; // Replace with a real recipient code
$recipient2Code = 'RCP_test_rec_2'; // Replace with another real recipient code

// 1. Initiate a new single transfer
try {
    $initTransferResponse = $client->transfer()->init([
        'source' => 'balance', // Funds come from your Paystack balance
        'amount' => 100000, // NGN 1,000.00 in kobo
        'recipient' => $recipient1Code,
        'reason' => 'Payment for services rendered',
        'currency' => 'NGN',
    ]);
    echo "Single Transfer Initiated:\n";
    print_r($initTransferResponse);
    $transferCode = $initTransferResponse['data']['transfer_code'] ?? null;
    $transferReference = $initTransferResponse['data']['reference'] ?? null;
    $transferStatus = $initTransferResponse['data']['status'] ?? null;
} catch (\Exception $e) {
    echo "Error initiating single transfer: " . $e->getMessage() . "\n";
    $transferCode = null;
    $transferReference = null;
    $transferStatus = null;
}

// 2. Finalize a transfer (if it requires OTP)
// This step is only necessary if your account settings require OTP for transfers.
// If the initial transfer status is 'otp', you'd prompt the user for OTP.
if ($transferStatus === 'otp' && $transferCode) {
    $userProvidedOtp = '123456'; // In a real app, this comes from user input
    try {
        $finalizeResponse = $client->transfer()->finalize($transferCode, $userProvidedOtp);
        echo "\nTransfer Finalized with OTP:\n";
        print_r($finalizeResponse);
    } catch (\Exception $e) {
        echo "Error finalizing transfer with OTP: " . $e->getMessage() . "\n";
    }
} else {
    echo "\nSkipping transfer finalization as OTP was not required or transfer code is missing.\n";
}

// 3. Initiate a bulk transfer
try {
    $bulkTransferResponse = $client->transfer()->bulk('balance', [
        [
            'amount' => 50000, // NGN 500.00
            'recipient' => $recipient1Code,
            'reason' => 'Weekly stipend',
        ],
        [
            'amount' => 75000, // NGN 750.00
            'recipient' => $recipient2Code,
            'reason' => 'Project payment',
        ],
    ]);
    echo "\nBulk Transfer Initiated:\n";
    print_r($bulkTransferResponse);
} catch (\Exception $e) {
    echo "Error initiating bulk transfer: " . $e->getMessage() . "\n";
}

// 4. List all transfers
try {
    $allTransfers = $client->transfer()->list(['perPage' => 5, 'status' => 'success']);
    echo "\nListing Successful Transfers (first 5):\n";
    if (!empty($allTransfers['data'])) {
        foreach ($allTransfers['data'] as $transfer) {
            echo "- Transfer ID: " . $transfer['id'] . ", Amount: " . ($transfer['amount'] / 100) . " " . $transfer['currency'] . ", Status: " . $transfer['status'] . "\n";
            if (!$transferCode && $transfer['status'] === 'success') { // Capture a transfer code if not already set
                $transferCode = $transfer['transfer_code'];
            }
        }
    } else {
        echo "No successful transfers found.\n";
    }
} catch (\Exception $e) {
    echo "Error listing transfers: " . $e->getMessage() . "\n";
}

// Ensure a transfer code is available for fetch/verify operations
if ($transferCode) {
    // 5. Fetch details of a specific transfer by ID
    // Note: The fetch method expects the transfer ID, not the transfer code.
    // You might need to get the ID from a list or init response.
    // For this example, we'll assume $transferCode can also be used as an ID if the API supports it,
    // or you'd need to map codes to IDs from a previous list operation.
    try {
        $fetchedTransfer = $client->transfer()->fetch($transferCode); // Assuming transferCode can be used as ID
        echo "\nFetched Transfer Details for '{$transferCode}':\n";
        print_r($fetchedTransfer);
    } catch (\Exception $e) {
        echo "Error fetching transfer '{$transferCode}': " . $e->getMessage() . "\n";
    }

    // 6. Verify the status of a transfer by reference
    // Use the reference obtained from the init response.
    if ($transferReference) {
        try {
            $verifiedTransfer = $client->transfer()->verify($transferReference);
            echo "\nVerified Transfer Status for Reference '{$transferReference}':\n";
            print_r($verifiedTransfer);
        } catch (\Exception $e) {
            echo "Error verifying transfer reference '{$transferReference}': " . $e->getMessage() . "\n";
        }
    } else {
        echo "\nSkipping transfer verification by reference as no valid reference is available.\n";
    }

} else {
    echo "\nSkipping transfer-specific operations as no valid transfer code is available.\n";
}

?>