### `Product`

This class provides methods to interact with the Paystack Products API. Products represent items or services that you sell, which can then be associated with Payment Pages or other Paystack features. You can create, list, fetch, and update your products.

| Method Name | Description | Parameters | Return Type | Example Usage |
|---|---|---|---|---|
| `create` | Creates a new product. | `array $params`: An array of parameters for the product: <br> - `name` (string, required): Name of the product. <br> - `description` (string, optional): Description of the product. <br> - `price` (int, required): Price of the product in kobo. <br> - `currency` (string, required): Currency of the product (e.g., `'NGN'`, `'GHS'`, `'USD'`). <br> - `unlimited` (bool, optional, default: `false`): Set to `true` if the product has unlimited stock. <br> - `quantity` (int, optional): Quantity of the product in stock (required if `unlimited` is `false`). | `array|string` | ```php $client->product()->create(['name' => 'E-Book: Advanced PHP', 'description' => 'A comprehensive guide to advanced PHP concepts.', 'price' => 750000, 'currency' => 'NGN', 'unlimited' => true]); ``` |
| `list` | Lists all products on your Paystack account. | `array $params = []`: Optional query parameters for filtering or pagination: <br> - `perPage` (int) <br> - `page` (int) <br> - `name` (string, filter by product name) <br> - `currency` (string, filter by currency) <br> - `from` (datetime) <br> - `to` (datetime) | `array|string` | ```php $client->product()->list(['currency' => 'NGN', 'perPage' => 10]); ``` |
| `fetch` | Fetches the details of a specific product using its ID. | `string $id`: The ID of the product. | `array|string` | ```php $client->product()->fetch('prod_xxxx'); ``` |
| `update` | Updates the details of an existing product. | `string $id`: The ID of the product. <br> `array $params = []`: An array of parameters to update (e.g., `name`, `description`, `price`, `quantity`, `active`). | `array|string` | ```php $client->product()->update('prod_xxxx', ['price' => 800000, 'quantity' => 50]); ``` |

**Usage and Sample Code:**

To use the `Product` class, you first need to initialize the Paystack client with your secret key. Once the client is initialized, you can access the `product()` method to interact with the Product API.

```php
<?php

require 'vendor/autoload.php';

use MusheAbdulHakim\Paystack\Paystack;

// Replace with your actual Paystack secret key
$secretKey = 'sk_test_xxxxxxxxxxxxxxxxxxxxxxxxxxxx';

// Initialize the Paystack client
$client = Paystack::client($secretKey);

// --- Sample Usage for Product Class ---

// 1. Create a new product (unlimited quantity)
try {
    $productName = 'Online Course: Web Development Basics - ' . uniqid();
    $createProductResponse = $client->product()->create([
        'name' => $productName,
        'description' => 'A beginner-friendly online course covering HTML, CSS, and JavaScript.',
        'price' => 1500000, // NGN 15,000.00 in kobo
        'currency' => 'NGN',
        'unlimited' => true, // This product has unlimited stock
    ]);
    echo "New Product Created:\n";
    print_r($createProductResponse);
    $productId = $createProductResponse['data']['id'] ?? null;
} catch (\Exception $e) {
    echo "Error creating product: " . $e->getMessage() . "\n";
    $productId = null;
}

// 2. Create another product (limited quantity)
try {
    $limitedProductName = 'Limited Edition T-Shirt - ' . uniqid();
    $createLimitedProductResponse = $client->product()->create([
        'name' => $limitedProductName,
        'description' => 'Exclusive T-shirt design, only 100 available.',
        'price' => 700000, // NGN 7,000.00 in kobo
        'currency' => 'NGN',
        'unlimited' => false,
        'quantity' => 100, // Limited stock
    ]);
    echo "\nNew Limited Quantity Product Created:\n";
    print_r($createLimitedProductResponse);
} catch (\Exception $e) {
    echo "Error creating limited quantity product: " . $e->getMessage() . "\n";
}


// 3. List all products
try {
    $allProducts = $client->product()->list(['perPage' => 5, 'currency' => 'NGN']);
    echo "\nListing Products (first 5 NGN products):\n";
    if (!empty($allProducts['data'])) {
        foreach ($allProducts['data'] as $product) {
            echo "- Product Name: " . $product['name'] . ", Price: " . ($product['price'] / 100) . " " . $product['currency'] . ", Quantity: " . ($product['unlimited'] ? 'Unlimited' : $product['quantity']) . "\n";
        }
    } else {
        echo "No products found.\n";
    }
} catch (\Exception $e) {
    echo "Error listing products: " . $e->getMessage() . "\n";
}

// Ensure a product ID is available for fetch/update operations
if ($productId) {
    // 4. Fetch details of a specific product by ID
    try {
        $fetchedProduct = $client->product()->fetch($productId);
        echo "\nFetched Product Details for ID '{$productId}':\n";
        print_r($fetchedProduct);
    } catch (\Exception $e) {
        echo "Error fetching product '{$productId}': " . $e->getMessage() . "\n";
    }

    // 5. Update an existing product (e.g., change price and description)
    try {
        $updateProductResponse = $client->product()->update($productId, [
            'price' => 1800000, // Update price to NGN 18,000.00
            'description' => 'An updated description for the web development course.',
        ]);
        echo "\nProduct '{$productId}' Updated:\n";
        print_r($updateProductResponse);
    } catch (\Exception $e) {
        echo "Error updating product: " . $e->getMessage() . "\n";
    }

} else {
    echo "\nSkipping product-specific operations as no valid product ID was obtained from creation.\n";
}

?>