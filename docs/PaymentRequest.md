### `PaymentRequest`

This class provides methods to interact with the Paystack Payment Requests API, also known as invoices. You can use this to create and manage requests for payment from your customers, track their status, and send reminders.

| Method Name | Description | Parameters | Return Type | Example Usage |
|---|---|---|---|---|
| `create` | Creates a new payment request (invoice). | `array $params`: An array of parameters for the payment request: <br> - `customer` (string, required): Customer email or customer code. <br> - `amount` (int, required): Amount in kobo. <br> - `due_date` (string, required): Date when payment is due (`YYYY-MM-DD`). <br> - `description` (string, optional): A description for the payment request. <br> - `line_items` (array, optional): Array of items, each with `name` and `amount`. <br> - `tax` (array, optional): Array of tax objects, each with `name` and `amount`. <br> - `send_notification` (bool, optional, default: `true`): Whether to send an email notification. <br> - `currency` (string, optional, default: `'NGN'`): Currency of the payment request. | `array|string` | ```php $client->paymentRequest()->create(['customer' => 'customer@example.com', 'amount' => 1500000, 'due_date' => '2025-12-31', 'description' => 'Invoice for services rendered']); ``` |
| `list` | Lists all payment requests on your Paystack account. | `array $params = []`: Optional query parameters for filtering or pagination: <br> - `perPage` (int) <br> - `page` (int) <br> - `status` (string, `'pending'`, `'paid'`, `'due'`, `'overdue'`) <br> - `customer` (string, customer email or code) <br> - `currency` (string) <br> - `from` (datetime) <br> - `to` (datetime) | `array|string` | ```php $client->paymentRequest()->list(['status' => 'pending', 'perPage' => 10]); ``` |
| `fetch` | Fetches the details of a specific payment request using its ID. | `string $id`: The ID of the payment request. | `array|string` | ```php $client->paymentRequest()->fetch('prq_xxxx'); ``` |
| `verify` | Verifies the status of a payment request using its unique code. | `string $code`: The unique code of the payment request. | `array|string` | ```php $client->paymentRequest()->verify('PRQ_xxxx'); ``` |
| `notify` | Sends a reminder notification for a payment request to the customer. | `string $code`: The unique code of the payment request to notify. | `array|string` | ```php $client->paymentRequest()->notify('PRQ_xxxx'); ``` |
| `total` | Retrieves the total amount of all payment requests on your account. | None | `array|string` | ```php $client->paymentRequest()->total(); ``` |
| `finalize` | Finalizes a payment request, marking it as complete. This can be used if payment was received offline. | `string $code`: The unique code of the payment request. <br> `bool $sendNotification`: Whether to send a notification to the customer after finalizing. | `array|string` | ```php $client->paymentRequest()->finalize('PRQ_xxxx', true); ``` |
| `update` | Updates the details of an existing payment request. | `string $id`: The ID of the payment request. <br> `array $params = []`: An array of parameters to update (e.g., `amount`, `due_date`, `description`, `status`). | `array|string` | ```php $client->paymentRequest()->update('prq_xxxx', ['amount' => 1200000, 'description' => 'Updated invoice for services']); ``` |
| `archive` | Archives a payment request, effectively hiding it from active lists. | `string $code`: The unique code of the payment request to archive. | `array|string` | ```php $client->paymentRequest()->archive('PRQ_xxxx'); ``` |

**Usage and Sample Code:**

To use the `PaymentRequest` class, you first need to initialize the Paystack client with your secret key. Once the client is initialized, you can access the `paymentRequest()` method to interact with the Payment Request API.

```php
<?php

require 'vendor/autoload.php';

use MusheAbdulHakim\Paystack\Paystack;

// Replace with your actual Paystack secret key
$secretKey = 'sk_test_xxxxxxxxxxxxxxxxxxxxxxxxxxxx';

// Initialize the Paystack client
$client = Paystack::client($secretKey);

// --- Sample Usage for PaymentRequest Class ---

// 1. Create a new payment request
try {
    $newPaymentRequest = $client->paymentRequest()->create([
        'customer' => 'customer@example.com', // Ensure this customer exists or create one
        'amount' => 2500000, // NGN 25,000.00 in kobo
        'due_date' => date('Y-m-d', strtotime('+7 days')), // Due in 7 days
        'description' => 'Invoice for Q3 Consulting Services',
        'line_items' => [
            ['name' => 'Consulting Hours', 'amount' => 2000000], // NGN 20,000
            ['name' => 'Travel Expenses', 'amount' => 500000],   // NGN 5,000
        ],
        'send_notification' => true,
    ]);
    echo "New Payment Request Created:\n";
    print_r($newPaymentRequest);
    $paymentRequestCode = $newPaymentRequest['data']['request_code'] ?? null;
    $paymentRequestId = $newPaymentRequest['data']['id'] ?? null;
} catch (\Exception $e) {
    echo "Error creating payment request: " . $e->getMessage() . "\n";
    $paymentRequestCode = null;
    $paymentRequestId = null;
}

// Ensure a payment request was created or use a known one for subsequent operations
if ($paymentRequestCode && $paymentRequestId) {
    // 2. Fetch details of a specific payment request by ID
    try {
        $fetchedPaymentRequest = $client->paymentRequest()->fetch($paymentRequestId);
        echo "\nFetched Payment Request by ID ('{$paymentRequestId}'):\n";
        print_r($fetchedPaymentRequest);
    } catch (\Exception $e) {
        echo "Error fetching payment request by ID: " . $e->getMessage() . "\n";
    }

    // 3. Verify the status of a payment request by code
    try {
        $verifiedPaymentRequest = $client->paymentRequest()->verify($paymentRequestCode);
        echo "\nVerified Payment Request by Code ('{$paymentRequestCode}'):\n";
        print_r($verifiedPaymentRequest);
    } catch (\Exception $e) {
        echo "Error verifying payment request by code: " . $e->getMessage() . "\n";
    }

    // 4. Send a reminder notification for the payment request
    try {
        $notifyResponse = $client->paymentRequest()->notify($paymentRequestCode);
        echo "\nNotification Sent for Payment Request '{$paymentRequestCode}':\n";
        print_r($notifyResponse);
    } catch (\Exception $e) {
        echo "Error sending notification: " . $e->getMessage() . "\n";
    }

    // 5. Update an existing payment request (e.g., change amount)
    try {
        $updateResponse = $client->paymentRequest()->update($paymentRequestId, [
            'amount' => 2600000, // Update amount to NGN 26,000.00
            'description' => 'Updated invoice with additional services',
        ]);
        echo "\nPayment Request '{$paymentRequestId}' Updated:\n";
        print_r($updateResponse);
    } catch (\Exception $e) {
        echo "Error updating payment request: " . $e->getMessage() . "\n";
    }

    // 6. Finalize a payment request (e.g., if paid offline)
    // This will mark the payment request as 'paid' on Paystack.
    // Use with caution, as it simulates a successful payment.
    try {
        $finalizeResponse = $client->paymentRequest()->finalize($paymentRequestCode, true); // Send notification
        echo "\nPayment Request '{$paymentRequestCode}' Finalized:\n";
        print_r($finalizeResponse);
    } catch (\Exception $e) {
        echo "Error finalizing payment request: " . $e->getMessage() . "\n";
    }

    // 7. Archive a payment request
    // This removes it from active lists but keeps it in your records.
    try {
        $archiveResponse = $client->paymentRequest()->archive($paymentRequestCode);
        echo "\nPayment Request '{$paymentRequestCode}' Archived:\n";
        print_r($archiveResponse);
    } catch (\Exception $e) {
        echo "Error archiving payment request: " . $e->getMessage() . "\n";
    }

} else {
    echo "\nSkipping payment request-specific operations as no valid request code/ID was obtained.\n";
}

// 8. List all payment requests (with status filter)
try {
    $paidRequests = $client->paymentRequest()->list(['status' => 'paid', 'perPage' => 5]);
    echo "\nListing Paid Payment Requests (first 5):\n";
    print_r($paidRequests);
} catch (\Exception $e) {
    echo "Error listing paid payment requests: " . $e->getMessage() . "\n";
}

// 9. Get total amount of all payment requests
try {
    $totalRequests = $client->paymentRequest()->total();
    echo "\nTotal Payment Requests Summary:\n";
    print_r($totalRequests);
} catch (\Exception $e) {
    echo "Error fetching total payment requests: " . $e->getMessage() . "\n";
}

?>