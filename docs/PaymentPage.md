### `PaymentPage`

This class provides methods to interact with the Paystack Payment Pages API. Payment Pages are simple, hosted pages that allow you to accept payments without needing to build a full checkout form. You can create, list, fetch, update payment pages, check slug availability, and even associate products with them.

| Method Name | Description | Parameters | Return Type | Example Usage |
|---|---|---|---|---|
| `create` | Creates a new payment page. | `string $name`: The name of the payment page (e.g., 'Donation Page', 'Product XYZ'). <br> `array $params = []`: Optional parameters for the page: <br> - `description` (string, optional): A description for the page. <br> - `amount` (int, optional): The fixed amount in kobo. If not provided, it's a variable amount page. <br> - `currency` (string, optional, default: `'NGN'`): The currency for the amount. <br> - `redirect_url` (string, optional): URL to redirect to after successful payment. <br> - `custom_fields` (array, optional): Custom fields to collect from the customer. <br> - `split_code` (string, optional): The split code for transaction split. <br> - `active` (bool, optional, default: `true`): Whether the page is active. | `array|string` | ```php $client->paymentPage()->create('My Awesome Product Page', ['description' => 'A page for my awesome product.', 'amount' => 2500000]); ``` |
| `list` | Lists all payment pages on your Paystack account. | `array $params = []`: Optional query parameters for filtering or pagination: <br> - `perPage` (int) <br> - `page` (int) <br> - `status` (string, `'active'` or `'inactive'`) <br> - `from` (datetime) <br> - `to` (datetime) | `array|string` | ```php $client->paymentPage()->list(['status' => 'active', 'perPage' => 10]); ``` |
| `fetch` | Fetches the details of a specific payment page using its ID or slug. | `string $id`: The ID or unique slug of the payment page. | `array|string` | ```php $client->paymentPage()->fetch('page_xxxx'); ``` |
| `update` | Updates the details of an existing payment page. | `string $id`: The ID or unique slug of the payment page. <br> `array $params = []`: An array of parameters to update (e.g., `name`, `description`, `amount`, `active`, `redirect_url`). | `array|string` | ```php $client->paymentPage()->update('page_xxxx', ['name' => 'Updated Product Page', 'active' => false]); ``` |
| `checkSlug` | Checks the availability of a payment page slug. Useful before creating a new page to ensure the desired slug is not taken. | `string $slug`: The slug to check (e.g., `'my-product-page'`). | `array|string` | ```php $client->paymentPage()->checkSlug('my-unique-product-page'); ``` |
| `addProduct` | Adds one or more products to a payment page. This allows customers to select products on the page. | `string $id`: The ID of the payment page. <br> `array $products = []`: An array of product IDs to add to the page. | `array|string` | ```php $client->paymentPage()->addProduct('page_xxxx', ['prod_yyyy', 'prod_zzzz']); ``` |

**Usage and Sample Code:**

To use the `PaymentPage` class, you first need to initialize the Paystack client with your secret key. Once the client is initialized, you can access the `paymentPage()` method to interact with the Payment Pages API.

```php
<?php

require 'vendor/autoload.php';

use MusheAbdulHakim\Paystack\Paystack;

// Replace with your actual Paystack secret key
$secretKey = 'sk_test_xxxxxxxxxxxxxxxxxxxxxxxxxxxx';

// Initialize the Paystack client
$client = Paystack::client($secretKey);

// --- Sample Usage for PaymentPage Class ---

// 1. Create a new payment page (fixed amount)
try {
    $newPageName = 'My Awesome Fixed Price Product';
    $createPageResponse = $client->paymentPage()->create($newPageName, [
        'description' => 'A page for a fixed-price digital product.',
        'amount' => 500000, // NGN 5000.00 in kobo
        'currency' => 'NGN',
        'redirect_url' => '[https://yourwebsite.com/payment-success](https://yourwebsite.com/payment-success)',
    ]);
    echo "New Fixed-Amount Payment Page Created:\n";
    print_r($createPageResponse);
    $fixedPageId = $createPageResponse['data']['id'] ?? null;
    $fixedPageSlug = $createPageResponse['data']['slug'] ?? null;
} catch (\Exception $e) {
    echo "Error creating fixed-amount payment page: " . $e->getMessage() . "\n";
    $fixedPageId = null;
    $fixedPageSlug = null;
}

// 2. Create a new payment page (variable amount - for donations)
try {
    $donationPageName = 'Support Our Cause';
    $createDonationPageResponse = $client->paymentPage()->create($donationPageName, [
        'description' => 'Help us continue our work. Any amount is appreciated!',
        'amount' => null, // Set to null for variable amount
    ]);
    echo "\nNew Variable-Amount Payment Page (Donation) Created:\n";
    print_r($createDonationPageResponse);
} catch (\Exception $e) {
    echo "Error creating variable-amount payment page: " . $e->getMessage() . "\n";
}

// 3. List all payment pages
try {
    $allPaymentPages = $client->paymentPage()->list(['perPage' => 5]);
    echo "\nListing Payment Pages (first 5):\n";
    if (!empty($allPaymentPages['data'])) {
        foreach ($allPaymentPages['data'] as $page) {
            echo "- Page Name: " . $page['name'] . ", Slug: " . $page['slug'] . ", Status: " . ($page['active'] ? 'Active' : 'Inactive') . "\n";
        }
    } else {
        echo "No payment pages found.\n";
    }
} catch (\Exception $e) {
    echo "Error listing payment pages: " . $e->getMessage() . "\n";
}

// Ensure a page ID is available for fetch/update operations
if ($fixedPageId) {
    // 4. Fetch details of a specific payment page by ID
    try {
        $fetchedPageById = $client->paymentPage()->fetch($fixedPageId);
        echo "\nFetched Payment Page by ID ('{$fixedPageId}'):\n";
        print_r($fetchedPageById);
    } catch (\Exception $e) {
        echo "Error fetching payment page by ID: " . $e->getMessage() . "\n";
    }

    // 5. Fetch details of a specific payment page by slug
    if ($fixedPageSlug) {
        try {
            $fetchedPageBySlug = $client->paymentPage()->fetch($fixedPageSlug);
            echo "\nFetched Payment Page by Slug ('{$fixedPageSlug}'):\n";
            print_r($fetchedPageBySlug);
        } catch (\Exception $e) {
            echo "Error fetching payment page by slug: " . $e->getMessage() . "\n";
        }
    }

    // 6. Update an existing payment page (e.g., deactivate it)
    try {
        $updatePageResponse = $client->paymentPage()->update($fixedPageId, [
            'active' => false, // Deactivate the page
            'description' => 'This product is no longer available.',
        ]);
        echo "\nPayment Page '{$fixedPageId}' Updated (Deactivated):\n";
        print_r($updatePageResponse);
    } catch (\Exception $e) {
        echo "Error updating payment page: " . $e->getMessage() . "\n";
    }

    // Reactivate for further testing if needed
    try {
        $client->paymentPage()->update($fixedPageId, ['active' => true]);
        echo "\nPayment Page '{$fixedPageId}' Reactivated.\n";
    } catch (\Exception $e) {
        echo "Error reactivating payment page: " . $e->getMessage() . "\n";
    }

} else {
    echo "\nSkipping page-specific operations as no valid page ID was obtained from creation.\n";
}

// 7. Check slug availability
$testSlug = 'my-unique-product-page-' . uniqid();
try {
    $slugAvailability = $client->paymentPage()->checkSlug($testSlug);
    echo "\nChecking Slug Availability for '{$testSlug}':\n";
    print_r($slugAvailability);
    if ($slugAvailability['status'] === true && $slugAvailability['data']['available'] === true) {
        echo "Slug '{$testSlug}' is available!\n";
    } else {
        echo "Slug '{$testSlug}' is NOT available.\n";
    }
} catch (\Exception $e) {
    echo "Error checking slug availability: " . $e->getMessage() . "\n";
}

// 8. Add products to a payment page (requires existing product IDs)
// First, create a dummy product if you don't have one
$dummyProductId = null;
try {
    $dummyProduct = $client->product()->create([
        'name' => 'Dummy Product for Page',
        'description' => 'A product to be added to a payment page.',
        'price' => 100000, // NGN 1000.00
        'currency' => 'NGN',
    ]);
    $dummyProductId = $dummyProduct['data']['id'] ?? null;
    echo "\nDummy Product Created for Page: " . ($dummyProductId ? $dummyProductId : 'Failed') . "\n";
} catch (\Exception $e) {
    echo "Error creating dummy product: " . $e->getMessage() . "\n";
}

if ($fixedPageId && $dummyProductId) {
    try {
        $addProductsResponse = $client->paymentPage()->addProduct($fixedPageId, [$dummyProductId]);
        echo "\nProduct '{$dummyProductId}' Added to Page '{$fixedPageId}':\n";
        print_r($addProductsResponse);
    } catch (\Exception $e) {
        echo "Error adding product to page: " . $e->getMessage() . "\n";
    }
} else {
    echo "\nSkipping addProduct operation as either page ID or dummy product ID is missing.\n";
}

?>