### `ApplePay`

This class provides methods to interact with the Paystack Apple Pay API, allowing you to register, list, and unregister domains for Apple Pay.

| Method Name | Description | Parameters | Return Type | Example Usage |
|---|---|---|---|---|
| `register` | Registers a domain for Apple Pay. | `string $domain`: The domain name to register. | `array|string` | ```php $client->applePay()->register('yourdomain.com'); ``` |
| `list` | Lists all registered Apple Pay domains. | `array $params = []`: Optional query parameters for filtering or pagination. | `array|string` | ```php $client->applePay()->list(['perPage' => 10]); ``` |
| `unregister` | Unregisters a domain from Apple Pay. | `string $domain`: The domain name to unregister. | `array|string` | ```php $client->applePay()->unregister('yourdomain.com'); ``` |

**Usage and Sample Code:**

To use the `ApplePay` class, you first need to initialize the Paystack client with your secret key. Once the client is initialized, you can access the `applePay()` method to interact with the Apple Pay API.

```php
<?php

require 'vendor/autoload.php';

use MusheAbdulHakim\Paystack\Paystack;

// Replace with your actual Paystack secret key
$secretKey = 'sk_test_xxxxxxxxxxxxxxxxxxxxxxxxxxxx';

// Initialize the Paystack client
$client = Paystack::client($secretKey);

// --- Sample Usage for ApplePay Class ---

// 1. Register an Apple Pay domain
// This registers a domain where you intend to display Apple Pay buttons.
// The domain must be verified with Paystack.
try {
    $domainToRegister = 'your-new-domain.com';
    $registerResponse = $client->applePay()->register($domainToRegister);
    echo "Apple Pay Domain Registered Successfully:\n";
    print_r($registerResponse);
} catch (\Exception $e) {
    echo "Error registering Apple Pay domain: " . $e->getMessage() . "\n";
    // Handle specific errors, e.g., domain already registered, invalid domain.
}

// 2. List all registered Apple Pay domains
// This fetches a list of all domains currently registered for Apple Pay on your Paystack account.
try {
    $applePayDomains = $client->applePay()->list();
    echo "\nRegistered Apple Pay Domains:\n";
    if (!empty($applePayDomains['data'])) {
        foreach ($applePayDomains['data'] as $domain) {
            echo "- " . $domain['domain_name'] . " (ID: " . $domain['id'] . ")\n";
        }
    } else {
        echo "No Apple Pay domains registered.\n";
    }

    // You can also add pagination parameters
    $paginatedDomains = $client->applePay()->list(['perPage' => 5, 'page' => 1]);
    echo "\nPaginated Apple Pay Domains (first 5):\n";
    print_r($paginatedDomains);

} catch (\Exception $e) {
    echo "Error listing Apple Pay domains: " . $e->getMessage() . "\n";
}

// 3. Unregister an Apple Pay domain
// This removes a domain from your registered Apple Pay domains.
try {
    $domainToUnregister = 'your-old-domain.com'; // Replace with a domain you wish to unregister
    $unregisterResponse = $client->applePay()->unregister($domainToUnregister);
    echo "\nApple Pay Domain Unregistered Successfully:\n";
    print_r($unregisterResponse);
} catch (\Exception $e) {
    echo "Error unregistering Apple Pay domain: " . $e->getMessage() . "\n";
    // Handle specific errors, e.g., domain not found, invalid operation.
}

?>