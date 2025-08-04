### `Plan`

This class provides methods to interact with the Paystack Plans API. Plans are used for managing recurring payments and subscriptions. You can create, list, fetch, and update subscription plans, defining their name, amount, and billing interval.

| Method Name | Description | Parameters | Return Type | Example Usage |
|---|---|---|---|---|
| `create` | Creates a new subscription plan. | `array $params`: An array of parameters for the plan: <br> - `name` (string, required): Name of the plan. <br> - `amount` (int, required): Amount to charge in kobo. <br> - `interval` (string, required): Billing interval (`'daily'`, `'weekly'`, `'monthly'`, `'quarterly'`, `'annually'`). <br> - `currency` (string, optional, default: `'NGN'`): Currency of the plan. <br> - `description` (string, optional): Description of the plan. <br> - `send_invoices` (bool, optional, default: `true`): Whether to send invoices for subscriptions. <br> - `send_sms` (bool, optional, default: `true`): Whether to send SMS reminders. <br> - `invoice_limit` (int, optional): Number of invoices to raise before stopping. | `array|string` | ```php $client->plan()->create(['name' => 'Premium Monthly', 'amount' => 1000000, 'interval' => 'monthly', 'currency' => 'NGN']); ``` |
| `list` | Lists all subscription plans on your Paystack account. | `array $params = []`: Optional query parameters for filtering or pagination: <br> - `perPage` (int) <br> - `page` (int) <br> - `interval` (string, e.g., `'monthly'`, `'annually'`) <br> - `amount` (int, amount in kobo) <br> - `status` (string, `'active'`, `'inactive'`) <br> - `from` (datetime) <br> - `to` (datetime) | `array|string` | ```php $client->plan()->list(['interval' => 'annually', 'status' => 'active']); ``` |
| `fetch` | Fetches the details of a specific subscription plan using its ID or plan code. | `string $id`: The ID or unique code of the plan. | `array|string` | ```php $client->plan()->fetch('plan_xxxx'); ``` |
| `update` | Updates the details of an existing subscription plan. | `string $id`: The ID or unique code of the plan. <br> `array $params = []`: An array of parameters to update (e.g., `name`, `amount`, `interval`, `description`, `active`). | `array|string` | ```php $client->plan()->update('plan_xxxx', ['name' => 'Pro Plan Updated', 'active' => false]); ``` |

**Usage and Sample Code:**

To use the `Plan` class, you first need to initialize the Paystack client with your secret key. Once the client is initialized, you can access the `plan()` method to interact with the Plan API.

```php
<?php

require 'vendor/autoload.php';

use MusheAbdulHakim\Paystack\Paystack;

// Replace with your actual Paystack secret key
$secretKey = 'sk_test_xxxxxxxxxxxxxxxxxxxxxxxxxxxx';

// Initialize the Paystack client
$client = Paystack::client($secretKey);

// --- Sample Usage for Plan Class ---

// 1. Create a new subscription plan
try {
    $planName = 'Basic Monthly Subscription - ' . uniqid();
    $createPlanResponse = $client->plan()->create([
        'name' => $planName,
        'amount' => 1000000, // NGN 10,000.00 in kobo
        'interval' => 'monthly',
        'currency' => 'NGN',
        'description' => 'Access to basic features, billed monthly.',
        'send_invoices' => true,
        'send_sms' => false,
    ]);
    echo "New Subscription Plan Created:\n";
    print_r($createPlanResponse);
    $planId = $createPlanResponse['data']['id'] ?? null;
    $planCode = $createPlanResponse['data']['plan_code'] ?? null;
} catch (\Exception $e) {
    echo "Error creating plan: " . $e->getMessage() . "\n";
    $planId = null;
    $planCode = null;
}

// 2. List all subscription plans
try {
    $allPlans = $client->plan()->list(['perPage' => 5, 'status' => 'active']);
    echo "\nListing Active Subscription Plans (first 5):\n";
    if (!empty($allPlans['data'])) {
        foreach ($allPlans['data'] as $plan) {
            echo "- Plan Name: " . $plan['name'] . ", Code: " . $plan['plan_code'] . ", Interval: " . $plan['interval'] . ", Amount: " . ($plan['amount'] / 100) . " " . $plan['currency'] . "\n";
        }
    } else {
        echo "No active plans found.\n";
    }
} catch (\Exception $e) {
    echo "Error listing plans: " . $e->getMessage() . "\n";
}

// Ensure a plan ID/code is available for fetch/update operations
if ($planId || $planCode) {
    $idToUse = $planId ?: $planCode; // Prefer ID if available, otherwise code

    // 3. Fetch details of a specific plan by ID or code
    try {
        $fetchedPlan = $client->plan()->fetch($idToUse);
        echo "\nFetched Plan Details for '{$idToUse}':\n";
        print_r($fetchedPlan);
    } catch (\Exception $e) {
        echo "Error fetching plan '{$idToUse}': " . $e->getMessage() . "\n";
    }

    // 4. Update an existing plan (e.g., change name and deactivate)
    try {
        $updatePlanResponse = $client->plan()->update($idToUse, [
            'name' => 'Updated Basic Monthly Plan',
            'active' => false, // Deactivate the plan
        ]);
        echo "\nPlan '{$idToUse}' Updated (and Deactivated):\n";
        print_r($updatePlanResponse);
    } catch (\Exception $e) {
        echo "Error updating plan: " . $e->getMessage() . "\n";
    }

    // You can reactivate it if needed for further testing
    try {
        $client->plan()->update($idToUse, ['active' => true]);
        echo "\nPlan '{$idToUse}' Reactivated.\n";
    } catch (\Exception $e) {
        echo "Error reactivating plan: " . $e->getMessage() . "\n";
    }

} else {
    echo "\nSkipping plan-specific operations as no valid plan ID/code was obtained from creation.\n";
}

?>