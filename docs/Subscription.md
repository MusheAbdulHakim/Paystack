### `Subscription`

This class provides methods to interact with the Paystack Subscription API. Subscriptions allow you to manage recurring payments for your customers based on defined plans. You can create, list, fetch, enable, disable subscriptions, and generate/send management links.

| Method Name | Description | Parameters | Return Type | Example Usage |
|---|---|---|---|---|
| `create` | Creates a new subscription for a customer to a specific plan. | `array $params`: An array of parameters for the subscription: <br> - `customer` (string, required): Customer email or customer code. <br> - `plan` (string, required): Plan ID or plan code. <br> - `authorization` (string, optional): Authorization code to charge. Required if customer doesn't have a saved card. <br> - `start_date` (string, optional, `YYYY-MM-DD`): Date to start the subscription. <br> - `risk_action` (string, optional): `'default'`, `'allow'`, `'deny'`. | `array|string` | ```php $client->subscription()->create(['customer' => 'customer@example.com', 'plan' => 'PLN_xxxx', 'authorization' => 'AUTH_yyyy']); ``` |
| `list` | Lists all subscriptions on your Paystack account. | `array $params = []`: Optional query parameters for filtering or pagination: <br> - `perPage` (int) <br> - `page` (int) <br> - `customer` (string, customer email or code) <br> - `plan` (string, plan ID or code) <br> - `status` (string, `'active'`, `'inactive'`, `'cancelled'`, `'completed'`, `'failed'`, `'pending'`) <br> - `from` (datetime) <br> - `to` (datetime) | `array|string` | ```php $client->subscription()->list(['status' => 'active', 'perPage' => 10]); ``` |
| `fetch` | Fetches the details of a specific subscription using its ID or subscription code. | `string $id`: The ID or unique code of the subscription. | `array|string` | ```php $client->subscription()->fetch('sub_xxxx'); ``` |
| `enable` | Enables a disabled subscription. This requires the subscription code and an email token. | `string $code`: The subscription code. <br> `string $token`: The email token associated with the customer's email. | `array|string` | ```php $client->subscription()->enable('SUB_xxxx', 'email_token_yyyy'); ``` |
| `disable` | Disables an active subscription. This requires the subscription code and an email token. | `string $code`: The subscription code. <br> `string $token`: The email token associated with the customer's email. | `array|string` | ```php $client->subscription()->disable('SUB_xxxx', 'email_token_yyyy'); ``` |
| `generateLink` | Generates a one-time link for a customer to manage their subscription. | `string $code`: The subscription code. | `array|string` | ```php $client->subscription()->generateLink('SUB_xxxx'); ``` |
| `sendLink` | Sends a one-time management link to the customer's email for a specific subscription. | `string $code`: The subscription code. | `array|string` | ```php $client->subscription()->sendLink('SUB_xxxx'); ``` |

**Usage and Sample Code:**

To use the `Subscription` class, you first need to initialize the Paystack client with your secret key. Once the client is initialized, you can access the `subscription()` method to interact with the Subscription API.

```php
<?php

require 'vendor/autoload.php';

use MusheAbdulHakim\Paystack\Paystack;

// Replace with your actual Paystack secret key
$secretKey = 'sk_test_xxxxxxxxxxxxxxxxxxxxxxxxxxxx';

// Initialize the Paystack client
$client = Paystack::client($secretKey);

// --- Sample Usage for Subscription Class ---

// Prerequisites:
// 1. A Customer: Ensure 'customer@example.com' exists or create one.
// 2. A Plan: Ensure 'PLN_xxxx' exists or create one using the Plan API.
// 3. An Authorization: For initial subscription creation if the customer doesn't have a saved card.
//    This typically comes from a successful transaction.

$sampleCustomerEmail = 'customer@example.com'; // Replace with a real customer email/code
$samplePlanCode = 'PLN_xxxxxxxxxxxx'; // Replace with a real plan code (e.g., from Plan::create() response)
$sampleAuthorizationCode = 'AUTH_yyyyyyyyyyyy'; // Replace with a real authorization code

// 1. Create a new subscription
try {
    $createSubscriptionResponse = $client->subscription()->create([
        'customer' => $sampleCustomerEmail,
        'plan' => $samplePlanCode,
        'authorization' => $sampleAuthorizationCode, // Required if customer has no saved card
    ]);
    echo "New Subscription Created:\n";
    print_r($createSubscriptionResponse);
    $subscriptionId = $createSubscriptionResponse['data']['id'] ?? null;
    $subscriptionCode = $createSubscriptionResponse['data']['subscription_code'] ?? null;
    $emailToken = $createSubscriptionResponse['data']['email_token'] ?? null; // Important for enable/disable
} catch (\Exception $e) {
    echo "Error creating subscription: " . $e->getMessage() . "\n";
    $subscriptionId = null;
    $subscriptionCode = null;
    $emailToken = null;
}

// 2. List all subscriptions
try {
    $allSubscriptions = $client->subscription()->list(['perPage' => 5, 'status' => 'active']);
    echo "\nListing Active Subscriptions (first 5):\n";
    if (!empty($allSubscriptions['data'])) {
        foreach ($allSubscriptions['data'] as $sub) {
            echo "- Sub ID: " . $sub['id'] . ", Code: " . $sub['subscription_code'] . ", Status: " . $sub['status'] . ", Customer: " . $sub['customer']['email'] . "\n";
            // Capture a subscription code and token for enable/disable if not already set
            if (!$subscriptionCode && $sub['status'] === 'active') {
                $subscriptionCode = $sub['subscription_code'];
                $emailToken = $sub['email_token'];
            }
        }
    } else {
        echo "No active subscriptions found.\n";
    }
} catch (\Exception $e) {
    echo "Error listing subscriptions: " . $e->getMessage() . "\n";
}

// Ensure a subscription code and token are available for subsequent operations
if ($subscriptionCode && $emailToken) {
    // 3. Fetch details of a specific subscription by ID or code
    try {
        $fetchedSubscription = $client->subscription()->fetch($subscriptionCode);
        echo "\nFetched Subscription Details for '{$subscriptionCode}':\n";
        print_r($fetchedSubscription);
    } catch (\Exception $e) {
        echo "Error fetching subscription '{$subscriptionCode}': " . $e->getMessage() . "\n";
    }

    // 4. Disable a subscription
    // This will stop recurring charges for the subscription.
    try {
        $disableResponse = $client->subscription()->disable($subscriptionCode, $emailToken);
        echo "\nSubscription '{$subscriptionCode}' Disabled:\n";
        print_r($disableResponse);
    } catch (\Exception $e) {
        echo "Error disabling subscription: " . $e->getMessage() . "\n";
    }

    // 5. Enable a subscription
    // This will reactivate a previously disabled subscription.
    try {
        $enableResponse = $client->subscription()->enable($subscriptionCode, $emailToken);
        echo "\nSubscription '{$subscriptionCode}' Enabled:\n";
        print_r($enableResponse);
    } catch (\Exception $e) {
        echo "Error enabling subscription: " . $e->getMessage() . "\n";
    }

    // 6. Generate a management link for the subscription
    // This link can be sent to the customer to manage their subscription directly.
    try {
        $manageLinkResponse = $client->subscription()->generateLink($subscriptionCode);
        echo "\nGenerated Management Link for '{$subscriptionCode}':\n";
        print_r($manageLinkResponse);
        if (isset($manageLinkResponse['data']['link'])) {
            echo "Management Link: " . $manageLinkResponse['data']['link'] . "\n";
        }
    } catch (\Exception $e) {
        echo "Error generating management link: " . $e->getMessage() . "\n";
    }

    // 7. Send a management link to the customer's email
    // Paystack will send an email with the management link to the customer.
    try {
        $sendLinkResponse = $client->subscription()->sendLink($subscriptionCode);
        echo "\nSent Management Link Email for '{$subscriptionCode}':\n";
        print_r($sendLinkResponse);
    } catch (\Exception $e) {
        echo "Error sending management link email: " . $e->getMessage() . "\n";
    }

} else {
    echo "\nSkipping subscription-specific operations as no valid subscription code/token was obtained.\n";
}

?>