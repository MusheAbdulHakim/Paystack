### `Terminal`

This class provides methods to interact with the Paystack Terminal API. This API allows you to manage and communicate with physical Paystack terminals (POS devices), enabling you to send commands, check their status, and manage their lifecycle (commissioning and decommissioning).

| Method Name | Description | Parameters | Return Type | Example Usage |
|---|---|---|---|---|
| `sendEvent` | Sends a specific event or command to a connected terminal. | `string $terminalId`: The ID of the terminal to send the event to. <br> `array $params = []`: An array containing event details: <br> - `type` (string, required): Type of event (e.g., `'print_receipt'`, `'transaction'`). <br> - `data` (array, required): Event-specific data (e.g., `['text' => 'Hello']` for `print_receipt`, or transaction details for `transaction`). | `array|string` | ```php $client->terminal()->sendEvent('term_xxxx', ['type' => 'print_receipt', 'data' => ['text' => 'Thank you for your purchase!']]); ``` |
| `eventStatus` | Checks the status of a specific event that was previously sent to a terminal. | `string $terminalId`: The ID of the terminal. <br> `string $eventId`: The ID of the event whose status you want to check. | `array|string` | ```php $client->terminal()->eventStatus('term_xxxx', 'event_yyyy'); ``` |
| `status` | Checks the online/offline presence status of a terminal. | `string $terminalId`: The ID of the terminal. | `array|string` | ```php $client->terminal()->status('term_xxxx'); ``` |
| `list` | Lists all terminals associated with your Paystack account. | `array $params = []`: Optional query parameters for filtering or pagination (e.g., `perPage`, `page`, `status`). | `array|string` | ```php $client->terminal()->list(['perPage' => 10]); ``` |
| `fetch` | Fetches the details of a specific terminal using its ID. | `string $terminalId`: The ID of the terminal. | `array|string` | ```php $client->terminal()->fetch('term_xxxx'); ``` |
| `update` | Updates the details of an existing terminal. | `string $terminalId`: The ID of the terminal. <br> `array $params = []`: An array of parameters to update (e.g., `name`, `device_id`, `location`). | `array|string` | ```php $client->terminal()->update('term_xxxx', ['name' => 'Main Store POS']); ``` |
| `commission` | Commissions a new terminal device, associating it with your Paystack account. | `array $params = []`: An array containing device details: <br> - `serial_number` (string, required): The unique serial number of the terminal device. <br> - `device_name` (string, required): A friendly name for the device. | `array|string` | ```php $client->terminal()->commission(['serial_number' => 'ABC123XYZ', 'device_name' => 'New Kiosk POS']); ``` |
| `deCommission` | Decommissions a terminal device, disassociating it from your Paystack account. | `array $params = []`: An array containing device details: <br> - `serial_number` (string, required): The serial number of the terminal device to decommission. | `array|string` | ```php $client->terminal()->deCommission(['serial_number' => 'ABC123XYZ']); ``` |

**Usage and Sample Code:**

To use the `Terminal` class, you first need to initialize the Paystack client with your secret key. Once the client is initialized, you can access the `terminal()` method to interact with the Terminal API.

```php
<?php

require 'vendor/autoload.php';

use MusheAbdulHakim\Paystack\Paystack;

// Replace with your actual Paystack secret key
$secretKey = 'sk_test_xxxxxxxxxxxxxxxxxxxxxxxxxxxx';

// Initialize the Paystack client
$client = Paystack::client($secretKey);

// --- Sample Usage for Terminal Class ---

// Note: To fully test these features, you need access to a physical Paystack terminal
// and its serial number/ID. For demonstration, we'll use placeholder IDs.

$sampleTerminalId = 'term_xxxxxxxxxxxx'; // Replace with a real terminal ID from your Paystack dashboard
$sampleEventId = 'event_yyyyyyyyyyyy'; // Replace with a real event ID if testing eventStatus

// 1. Commission a new terminal device
// This registers a physical terminal with your Paystack account.
try {
    $newTerminalSerialNumber = 'SN-APP-001-' . uniqid(); // Use a unique serial number
    $commissionResponse = $client->terminal()->commission([
        'serial_number' => $newTerminalSerialNumber,
        'device_name' => 'My New Test POS',
    ]);
    echo "New Terminal Commissioned:\n";
    print_r($commissionResponse);
    $commissionedTerminalId = $commissionResponse['data']['id'] ?? null;
} catch (\Exception $e) {
    echo "Error commissioning terminal: " . $e->getMessage() . "\n";
    $commissionedTerminalId = null;
}

// Use the newly commissioned terminal ID or a known one for subsequent operations
$currentTerminalId = $commissionedTerminalId ?: $sampleTerminalId;

if ($currentTerminalId && $currentTerminalId !== $sampleTerminalId) {
    echo "\nUsing newly commissioned terminal ID: {$currentTerminalId}\n";
} elseif ($currentTerminalId === $sampleTerminalId) {
    echo "\nUsing sample terminal ID: {$currentTerminalId}\n";
} else {
    echo "\nNo valid terminal ID available for operations. Please ensure a terminal is commissioned or provide a valid sample ID.\n";
}


if ($currentTerminalId) {
    // 2. Send an event to the terminal (e.g., print a receipt)
    try {
        $sendEventResponse = $client->terminal()->sendEvent($currentTerminalId, [
            'type' => 'print_receipt',
            'data' => [
                'text' => "Hello from Paystack SDK!\nTransaction: #12345\nAmount: NGN 100.00\nDate: " . date('Y-m-d H:i:s'),
            ],
        ]);
        echo "\nPrint Receipt Event Sent to Terminal '{$currentTerminalId}':\n";
        print_r($sendEventResponse);
        $sentEventId = $sendEventResponse['data']['id'] ?? null;
    } catch (\Exception $e) {
        echo "Error sending print event to terminal '{$currentTerminalId}': " . $e->getMessage() . "\n";
        $sentEventId = null;
    }

    // 3. Check the status of a sent event
    if ($sentEventId) {
        try {
            $eventStatusResponse = $client->terminal()->eventStatus($currentTerminalId, $sentEventId);
            echo "\nStatus of Event '{$sentEventId}' on Terminal '{$currentTerminalId}':\n";
            print_r($eventStatusResponse);
        } catch (\Exception $e) {
            echo "Error checking event status '{$sentEventId}': " . $e->getMessage() . "\n";
        }
    } else {
        echo "\nSkipping event status check as no event ID was obtained.\n";
    }

    // 4. Check the online/offline status of the terminal
    try {
        $terminalStatus = $client->terminal()->status($currentTerminalId);
        echo "\nPresence Status of Terminal '{$currentTerminalId}':\n";
        print_r($terminalStatus);
    } catch (\Exception $e) {
        echo "Error checking terminal status '{$currentTerminalId}': " . $e->getMessage() . "\n";
    }

    // 5. Fetch details of a specific terminal
    try {
        $fetchedTerminal = $client->terminal()->fetch($currentTerminalId);
        echo "\nFetched Details for Terminal '{$currentTerminalId}':\n";
        print_r($fetchedTerminal);
    } catch (\Exception $e) {
        echo "Error fetching terminal '{$currentTerminalId}': " . $e->getMessage() . "\n";
    }

    // 6. Update an existing terminal
    try {
        $updateResponse = $client->terminal()->update($currentTerminalId, [
            'name' => 'Updated Main Store POS',
        ]);
        echo "\nTerminal '{$currentTerminalId}' Updated:\n";
        print_r($updateResponse);
    } catch (\Exception $e) {
        echo "Error updating terminal: " . $e->getMessage() . "\n";
    }

} else {
    echo "\nSkipping terminal-specific operations as no valid terminal ID is available.\n";
}

// 7. List all terminals
try {
    $allTerminals = $client->terminal()->list(['perPage' => 5]);
    echo "\nListing All Terminals (first 5):\n";
    if (!empty($allTerminals['data'])) {
        foreach ($allTerminals['data'] as $term) {
            echo "- Terminal Name: " . $term['name'] . ", ID: " . $term['id'] . ", Status: " . ($term['online'] ? 'Online' : 'Offline') . "\n";
        }
    } else {
        echo "No terminals found.\n";
    }
} catch (\Exception $e) {
    echo "Error listing terminals: " . $e->getMessage() . "\n";
}

// 8. Decommission a terminal device
// This removes the association of a physical terminal from your Paystack account.
// Use the serial number from the commissioning step or a known one.
if ($commissionedTerminalId && $newTerminalSerialNumber) { // Only decommission if we actually commissioned one
    try {
        $decommissionResponse = $client->terminal()->deCommission(['serial_number' => $newTerminalSerialNumber]);
        echo "\nTerminal '{$newTerminalSerialNumber}' Decommissioned:\n";
        print_r($decommissionResponse);
    } catch (\Exception $e) {
        echo "Error decommissioning terminal '{$newTerminalSerialNumber}': " . $e->getMessage() . "\n";
    }
} else {
    echo "\nSkipping decommission operation as no new terminal was commissioned in this run.\n";
}

?>