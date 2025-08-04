### `Transaction`

This class provides comprehensive methods to interact with the Paystack Transaction API, which is central to processing payments. You can initialize new transactions, verify their status, list past transactions, fetch detailed information, charge saved authorizations, view transaction timelines, get aggregated totals, export transaction data, and perform partial debits.

| Method Name | Description | Parameters | Return Type | Example Usage |
|---|---|---|---|---|
| `initialize` | Initializes a new transaction, returning an authorization URL for the customer to complete the payment. | `array $params`: An array of transaction details: <br> - `amount` (int, required): Amount in kobo. <br> - `email` (string, required): Customer's email address. <br> - `callback_url` (string, optional): URL to redirect to after payment. <br> - `reference` (string, optional): Unique transaction reference. If not provided, Paystack generates one. <br> - `metadata` (array, optional): Custom data to attach to the transaction. <br> - `channels` (array, optional): Allowed payment channels (e.g., `['card', 'bank_transfer']`). | `array|string` | ```php $client->transaction()->initialize(['amount' => 500000, 'email' => 'customer@example.com', 'callback_url' => '[https://yourwebsite.com/verify-payment](https://yourwebsite.com/verify-payment)']); ``` |
| `verify` | Verifies the status of a transaction using its reference. This should be called after a customer completes payment to confirm success. | `string $reference`: The unique transaction reference. | `array|string` | ```php $client->transaction()->verify('your_transaction_reference'); ``` |
| `list` | Lists all transactions on your Paystack account. | `array $params = []`: Optional query parameters for filtering or pagination: <br> - `perPage` (int) <br> - `page` (int) <br> - `status` (string, e.g., `'success'`, `'failed'`, `'abandoned'`) <br> - `customer` (int, customer ID) <br> - `from` (datetime) <br> - `to` (datetime) | `array|string` | ```php $client->transaction()->list(['status' => 'success', 'perPage' => 10]); ``` |
| `fetch` | Fetches the details of a specific transaction using its ID. | `int $id`: The ID of the transaction. | `array|string` | ```php $client->transaction()->fetch(123456789); ``` |
| `chargeAuth` | Charges an existing customer authorization (saved card token). This is used for recurring payments or one-click checkouts. | `array $params`: An array containing authorization details: <br> - `authorization_code` (string, required): The authorization code obtained from a previous successful transaction. <br> - `email` (string, required): Customer's email address. <br> - `amount` (int, required): Amount in kobo. <br> - `reference` (string, optional): Unique transaction reference. | `array|string` | ```php $client->transaction()->chargeAuth(['authorization_code' => 'AUTH_xxxx', 'email' => 'customer@example.com', 'amount' => 200000]); ``` |
| `view` | Views the timeline of a transaction, showing all events related to it (e.g., initiated, paid, failed). | `string $id`: The ID or reference of the transaction. | `array|string` | ```php $client->transaction()->view('your_transaction_reference'); ``` |
| `totals` | Retrieves aggregated totals of transactions on your account. | `array $params = []`: Optional query parameters for filtering totals (e.g., `from`, `to`, `status`). | `array|string` | ```php $client->transaction()->totals(['from' => '2024-01-01', 'to' => '2024-01-31']); ``` |
| `export` | Exports transactions data to a file. | `array $params = []`: Optional query parameters for filtering the export (e.g., `status`, `from`, `to`, `settled`). | `array|string` | ```php $client->transaction()->export(['status' => 'success', 'from' => '2024-01-01']); ``` |
| `partialDebit` | Performs a partial debit on an existing authorization. | `array $params`: An array containing partial debit details: <br> - `authorization_code` (string, required): The authorization code. <br> - `currency` (string, required): Currency of the transaction. <br> - `amount` (int, required): Amount to debit in kobo. <br> - `email` (string, required): Customer's email. <br> - `reference` (string, optional): Unique transaction reference. | `array|string` | ```php $client->transaction()->partialDebit(['authorization_code' => 'AUTH_xxxx', 'currency' => 'NGN', 'amount' => 100000, 'email' => 'customer@example.com']); ``` |

**Usage and Sample Code:**

To use the `Transaction` class, you first need to initialize the Paystack client with your secret key. Once the client is initialized, you can access the `transaction()` method to interact with the Transaction API.

```php
<?php

require 'vendor/autoload.php';

use MusheAbdulHakim\Paystack\Paystack;

// Replace with your actual Paystack secret key
$secretKey = 'sk_test_xxxxxxxxxxxxxxxxxxxxxxxxxxxx';

// Initialize the Paystack client
$client = Paystack::client($secretKey);

// --- Sample Usage for Transaction Class ---

// 1. Initialize a new transaction
// This is the first step to accepting payments. It generates a unique URL for the customer.
try {
    $initializeResponse = $client->transaction()->initialize([
        'amount' => 500000, // NGN 5,000.00 in kobo
        'email' => 'customer_' . uniqid() . '@example.com', // Use a unique email for testing
        'callback_url' => '[https://yourwebsite.com/payment-callback](https://yourwebsite.com/payment-callback)',
        'metadata' => [
            'cart_id' => 'CART-XYZ-123',
            'products' => ['item_a', 'item_b'],
        ],
    ]);
    echo "Transaction Initialization Response:\n";
    print_r($initializeResponse);
    $transactionReference = $initializeResponse['data']['reference'] ?? null;
    $authorizationUrl = $initializeResponse['data']['authorization_url'] ?? null;

    if ($authorizationUrl) {
        echo "Please direct your customer to this URL to complete payment: " . $authorizationUrl . "\n";
    }
} catch (\Exception $e) {
    echo "Error initializing transaction: " . $e->getMessage() . "\n";
    $transactionReference = null;
    $authorizationUrl = null;
}

// In a real application, after the customer completes payment on the authorization URL,
// Paystack sends a webhook to your `callback_url`. In that webhook, you would
// then call the `verify` method.

// Let's assume a transaction reference is available for verification (replace with a real one)
$knownTransactionReference = 'your_actual_transaction_reference_from_webhook'; // e.g., 'T1234567890'

// 2. Verify a transaction
// This confirms if a transaction was successful.
if ($knownTransactionReference) {
    try {
        $verifyResponse = $client->transaction()->verify($knownTransactionReference);
        echo "\nTransaction Verification Response for '{$knownTransactionReference}':\n";
        print_r($verifyResponse);
        if ($verifyResponse['status'] === true && $verifyResponse['data']['status'] === 'success') {
            echo "Transaction '{$knownTransactionReference}' successfully verified and paid.\n";
            $authorizationCode = $verifyResponse['data']['authorization']['authorization_code'] ?? null;
            $transactionId = $verifyResponse['data']['id'] ?? null;
        } else {
            echo "Transaction '{$knownTransactionReference}' verification failed or is not successful.\n";
            $authorizationCode = null;
            $transactionId = null;
        }
    } catch (\Exception $e) {
        echo "Error verifying transaction '{$knownTransactionReference}': " . $e->getMessage() . "\n";
        $authorizationCode = null;
        $transactionId = null;
    }
} else {
    echo "\nSkipping transaction verification as no valid reference is available.\n";
}

// 3. List all transactions
try {
    $allTransactions = $client->transaction()->list(['perPage' => 5, 'status' => 'success']);
    echo "\nListing Successful Transactions (first 5):\n";
    if (!empty($allTransactions['data'])) {
        foreach ($allTransactions['data'] as $trans) {
            echo "- Ref: " . $trans['reference'] . ", Amount: " . ($trans['amount'] / 100) . " " . $trans['currency'] . ", Status: " . $trans['status'] . "\n";
            if (!$transactionId) { // Capture a transaction ID if not already set
                $transactionId = $trans['id'];
            }
            if (!$authorizationCode && isset($trans['authorization']['authorization_code'])) {
                $authorizationCode = $trans['authorization']['authorization_code'];
            }
        }
    } else {
        echo "No successful transactions found.\n";
    }
} catch (\Exception $e) {
    echo "Error listing transactions: " . $e->getMessage() . "\n";
}

// Ensure a transaction ID is available for fetch/view operations
if ($transactionId) {
    // 4. Fetch details of a specific transaction by ID
    try {
        $fetchedTransaction = $client->transaction()->fetch($transactionId);
        echo "\nFetched Transaction Details for ID '{$transactionId}':\n";
        print_r($fetchedTransaction);
    } catch (\Exception $e) {
        echo "Error fetching transaction '{$transactionId}': " . $e->getMessage() . "\n";
    }

    // 5. View transaction timeline
    try {
        $timeline = $client->transaction()->view($transactionId); // Can also use reference
        echo "\nTransaction Timeline for '{$transactionId}':\n";
        print_r($timeline);
    } catch (\Exception $e) {
        echo "Error viewing transaction timeline '{$transactionId}': " . $e->getMessage() . "\n";
    }
} else {
    echo "\nSkipping transaction fetch/timeline as no valid transaction ID is available.\n";
}

// 6. Charge an authorization (for recurring payments)
if ($authorizationCode && $sampleCustomerEmail) { // Use a real authorization and email
    try {
        $chargeAuthResponse = $client->transaction()->chargeAuth([
            'authorization_code' => $authorizationCode,
            'email' => $sampleCustomerEmail,
            'amount' => 100000, // NGN 1,000.00
            'reference' => 'recurring_charge_' . uniqid(),
        ]);
        echo "\nCharge Authorization Response:\n";
        print_r($chargeAuthResponse);
        if ($chargeAuthResponse['status'] === true && $chargeAuthResponse['data']['status'] === 'success') {
            echo "Recurring charge successful!\n";
        } else {
            echo "Recurring charge failed or requires action.\n";
        }
    } catch (\Exception $e) {
        echo "Error charging authorization: " . $e->getMessage() . "\n";
    }
} else {
    echo "\nSkipping charge authorization as no valid authorization code or customer email is available.\n";
}

// 7. Get transaction totals
try {
    $totals = $client->transaction()->totals(['status' => 'success']);
    echo "\nTransaction Totals (Successful):\n";
    print_r($totals);
} catch (\Exception $e) {
    echo "Error fetching transaction totals: " . $e->getMessage() . "\n";
}

// 8. Export transactions
try {
    $exportResponse = $client->transaction()->export([
        'status' => 'success',
        'from' => '2024-01-01',
        'to' => date('Y-m-d'),
    ]);
    echo "\nTransaction Export Initiated:\n";
    print_r($exportResponse);
    if (isset($exportResponse['data']['path'])) {
        echo "Export file will be available at: " . $exportResponse['data']['path'] . "\n";
    }
} catch (\Exception $e) {
    echo "Error exporting transactions: " . $e->getMessage() . "\n";
}

// 9. Perform a partial debit (requires a valid authorization code)
if ($authorizationCode && $sampleCustomerEmail) {
    try {
        $partialDebitResponse = $client->transaction()->partialDebit([
            'authorization_code' => $authorizationCode,
            'currency' => 'NGN',
            'amount' => 50000, // NGN 500.00
            'email' => $sampleCustomerEmail,
            'reference' => 'partial_debit_' . uniqid(),
        ]);
        echo "\nPartial Debit Response:\n";
        print_r($partialDebitResponse);
        if ($partialDebitResponse['status'] === true && $partialDebitResponse['data']['status'] === 'success') {
            echo "Partial debit successful!\n";
        } else {
            echo "Partial debit failed or requires action.\n";
        }
    } catch (\Exception $e) {
        echo "Error performing partial debit: " . $e->getMessage() . "\n";
    }
} else {
    echo "\nSkipping partial debit as no valid authorization code or customer email is available.\n";
}

?>