<div align="center">
  <svg width="50" height="50" viewBox="0 0 29 28" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path fill-rule="evenodd" clip-rule="evenodd" d="M1.51165 0H25.7369C26.5715 0 27.2504 0.671185 27.2504 1.50214V4.16909C27.2504 4.99651 26.5716 5.67141 25.7369 5.67141H1.51165C0.676996 5.67141 0 4.99657 0 4.16909V1.50214C0 0.671185 0.676996 0 1.51165 0ZM1.51165 14.887H25.7369C26.5715 14.887 27.2504 15.5599 27.2504 16.3874V19.058C27.2504 19.8854 26.5716 20.5566 25.7369 20.5566H1.51165C0.676996 20.5566 0 19.8854 0 19.058V16.3874C0 15.5599 0.676996 14.887 1.51165 14.887ZM15.1376 22.3304H1.51165C0.676996 22.3304 0 23.0016 0 23.8309V26.4997C0 27.3272 0.676996 28 1.51165 28H15.1377C15.9759 28 16.6511 27.3272 16.6511 26.4997V23.8309C16.6511 23.0016 15.9759 22.3304 15.1376 22.3304ZM1.51165 7.44171H27.2504C28.0868 7.44171 28.7619 8.11469 28.7619 8.94379V11.6127C28.7619 12.4401 28.0868 13.1148 27.2504 13.1148H1.51165C0.676996 13.1148 0 12.4401 0 11.6127V8.94379C0 8.11469 0.676996 7.44171 1.51165 7.44171Z" fill="#09A5DB"></path>
  </svg>
  <h1>Paystack PHP SDK Documentation</h1>
</div>


## Welcome

This documentation provides a comprehensive guide to the `MusheAbdulHakim\Paystack` PHP SDK, a robust and intuitive library designed for seamless integration with the Paystack API. Built with a focus on developer experience, this SDK offers a fluent, object-oriented interface to manage your payments, customers, subscriptions, and more.

### Key Features:

* **Fluent API:** Chain method calls for clean, readable, and highly maintainable code.
* **Object-Oriented Design:** Encapsulates Paystack API endpoints into dedicated classes for logical organization.
* **PSR-18 HTTP Client Support:** Flexible integration with any PSR-18 compatible HTTP client.
* **Strong Typing:** Leverages PHP's type hints for improved code quality and IDE support.
* **Extensible Architecture:** Easily extendable to accommodate custom transporters or new API modules.

## Getting Started

### Installation

The recommended way to install the Paystack PHP SDK is via Composer:

```bash
composer require musheabdulhakim/paystack
````

### Quick Start

Initialize the Paystack client using your secret key to begin interacting with the API.

#### Simple Initialization:

```php
<?php

use MusheAbdulHakim\Paystack\Paystack;

$secretKey = 'sk_test_xxxxxxxxxxxxxxxxxxxxxxxxxxxx'; // Replace with your actual Paystack secret key

$client = Paystack::client($secretKey);

// Example: List all transactions
$transactions = $client->transaction()->list();
print_r($transactions);

?>
```

#### Advanced Initialization with Factory:

For more control over the HTTP client, base URI, or default headers, use the `Paystack::factory()` method:

```php
<?php

use MusheAbdulHakim\Paystack\Paystack;
use GuzzleHttp\Client as GuzzleHttpClient; // Example: Using Guzzle as a custom client

$secretKey = 'sk_test_xxxxxxxxxxxxxxxxxxxxxxxxxxxx'; // Replace with your actual Paystack secret key

$client = Paystack::factory()
    ->withSecretKey($secretKey)
    ->withBaseUri('[https://api.paystack.com/](https://api.paystack.com/)') // Optional: Specify a custom base URI
    ->withHeaders([ // Optional: Add custom headers
        'X-App-Version' => '1.0',
        'User-Agent' => 'MyCustomPaystackApp/1.0',
    ])
    ->withHttpClient(new GuzzleHttpClient()) // Optional: Provide a custom PSR-18 HTTP client
    ->make();

// Example: Create a new customer
$customer = $client->customer()->create([
    'email' => 'new.customer@example.com',
    'first_name' => 'New',
    'last_name' => 'Customer',
]);
print_r($customer);

?>
```

## API Reference

Explore the dedicated classes for each Paystack API resource:

  * [Apple Pay](./ApplePay.md)
      * Manage Apple Pay domains (register, list, unregister).
  * [Bulk Charges](./BulkCharge.md)
      * Initiate, list, fetch, pause, and resume bulk charge operations.
  * [Charges](./Charge.md)
      * Directly charge customers, submit authentication details (PIN, OTP, Phone, Birthday, Address), and check pending charge status.
  * [Customers](./Customer.md)
      * Create, list, fetch, update, validate customer details, and manage risk actions (blacklist/whitelist).
  * [Disputes](./Dispute.md)
      * List, fetch, update, resolve disputes, and upload/manage evidence.
  * [Integration](./Integration.md)
      * Fetch and update payment session timeout settings.
  * [Miscellaneous](./Miscellaneous.md)
      * Retrieve lists of banks, countries, and states.
  * [Payment Pages](./PaymentPage.md)
      * Create, list, fetch, update payment pages, check slug availability, and add products to pages.
  * [Payment Requests](./PaymentRequest.md)
      * Create, list, fetch, verify, notify, finalize, update, and archive payment requests (invoices), and get totals.
  * [Plans](./Plan.md)
      * Create, list, fetch, and update subscription plans.
  * [Products](./Product.md)
      * Create, list, fetch, and update products.
  * [Refunds](./Refund.md)
      * Create, list, and fetch details of refunds for transactions.
  * [Settlements](./Settlement.md)
      * List settlements and retrieve transactions associated with specific settlements.
  * [Subaccounts](./SubAccount.md)
      * Create, list, fetch, and update subaccounts for splitting payments.
  * [Subscriptions](./Subscription.md)
      * Create, list, fetch, enable, disable subscriptions, and generate/send management links.
  * [Terminals](./Terminal.md)
      * Send events to terminals, check event status, get terminal presence, list, fetch, update, commission, and decommission devices.
  * [Transactions](./Transaction.md)
      * Initialize, verify, list, fetch transactions, charge authorizations, view timelines, get totals, export data, and perform partial debits.
  * [Transaction Splits](./TransactionSplit.md)
      * Create, list, fetch, update transaction splits, and manage subaccounts within a split.
  * [Transfers](./Transfer.md)
      * Initiate single and bulk transfers, finalize transfers with OTP, list, fetch, and verify transfer status.
  * [Transfer Control](./TransferControl.md)
      * Retrieve account balance and ledger, and manage OTP settings for transfers.
  * [Transfer Recipients](./TransferRecipient.md)
      * Create single and bulk transfer recipients, list, fetch, update, and delete recipients.
  * [Verifications](./Verification.md)
      * Resolve bank accounts, validate bank accounts, and resolve card BINs.
  * [Virtual Accounts](./VirtualAccount.md)
      * Create, assign, list, fetch, requery, deactivate virtual accounts, manage split transactions, and retrieve bank providers.

## Extending the SDK

The `MusheAbdulHakim\Paystack` SDK is designed for extensibility. You can customize its behavior by providing your own PSR-18 HTTP client, or by implementing custom transporters to handle request/response logic. This allows for advanced use cases such as custom logging, error handling, or integrating with specific HTTP client libraries.

## License

This Paystack PHP SDK is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
