### `Miscellaneous`

This class provides methods to access various general and static data from Paystack, such as lists of banks, countries, and states. These endpoints are useful for populating dropdowns, validating inputs, or displaying information to your users.

| Method Name | Description | Parameters | Return Type | Example Usage |
|---|---|---|---|---|
| `banks` | Retrieves a list of banks supported by Paystack. You can filter this list by country or bank type. | `array $params = []`: Optional query parameters: <br> - `country` (string, e.g., `'nigeria'`, `'ghana'`) <br> - `type` (string, e.g., `'nuban'`, `'mobile_money'`) | `array|string` | ```php $client->miscellaneous()->banks(['country' => 'nigeria', 'type' => 'nuban']); ``` |
| `countries` | Retrieves a list of countries supported by Paystack. | None | `array|string` | ```php $client->miscellaneous()->countries(); ``` |
| `states` | Retrieves a list of states for address verification, typically filtered by country. | `array $params = []`: Optional query parameters: <br> - `country` (string, e.g., `'nigeria'`, `'ghana'`) | `array|string` | ```php $client->miscellaneous()->states(['country' => 'nigeria']); ``` |

**Usage and Sample Code:**

To use the `Miscellaneous` class, you first need to initialize the Paystack client with your secret key. Once the client is initialized, you can access the `miscellaneous()` method to interact with these general endpoints.

```php
<?php

require 'vendor/autoload.php';

use MusheAbdulHakim\Paystack\Paystack;

// Replace with your actual Paystack secret key
$secretKey = 'sk_test_xxxxxxxxxxxxxxxxxxxxxxxxxxxx';

// Initialize the Paystack client
$client = Paystack::client($secretKey);

// --- Sample Usage for Miscellaneous Class ---

// 1. Retrieve a list of banks (e.g., Nigerian NUBAN banks)
try {
    $nigerianBanks = $client->miscellaneous()->banks(['country' => 'nigeria', 'type' => 'nuban']);
    echo "Nigerian NUBAN Banks:\n";
    if (!empty($nigerianBanks['data'])) {
        foreach ($nigerianBanks['data'] as $bank) {
            echo "- " . $bank['name'] . " (Code: " . $bank['code'] . ")\n";
        }
    } else {
        echo "No Nigerian NUBAN banks found.\n";
    }
} catch (\Exception $e) {
    echo "Error fetching Nigerian banks: " . $e->getMessage() . "\n";
}

// 2. Retrieve a list of all supported countries
try {
    $countries = $client->miscellaneous()->countries();
    echo "\nSupported Countries:\n";
    if (!empty($countries['data'])) {
        // Limit output for brevity
        $count = 0;
        foreach ($countries['data'] as $country) {
            echo "- " . $country['name'] . " (Code: " . $country['iso_code'] . ")\n";
            $count++;
            if ($count >= 5) { // Show only first 5 countries
                echo "... (and more)\n";
                break;
            }
        }
    } else {
        echo "No countries found.\n";
    }
} catch (\Exception $e) {
    echo "Error fetching countries: " . $e->getMessage() . "\n";
}

// 3. Retrieve a list of states for address verification (e.g., for Nigeria)
try {
    $nigerianStates = $client->miscellaneous()->states(['country' => 'nigeria']);
    echo "\nNigerian States for Address Verification:\n";
    if (!empty($nigerianStates['data'])) {
        // Limit output for brevity
        $count = 0;
        foreach ($nigerianStates['data'] as $state) {
            echo "- " . $state['name'] . "\n";
            $count++;
            if ($count >= 5) { // Show only first 5 states
                echo "... (and more)\n";
                break;
            }
        }
    } else {
        echo "No Nigerian states found.\n";
    }
} catch (\Exception $e) {
    echo "Error fetching Nigerian states: " . $e->getMessage() . "\n";
}

?>