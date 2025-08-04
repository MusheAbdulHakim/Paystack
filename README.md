<div align="center">
<svg width="100" height="100" viewBox="0 0 29 28" fill="none"><path fill-rule="evenodd" clip-rule="evenodd" d="M1.51165 0H25.7369C26.5715 0 27.2504 0.671185 27.2504 1.50214V4.16909C27.2504 4.99651 26.5716 5.67141 25.7369 5.67141H1.51165C0.676996 5.67141 0 4.99657 0 4.16909V1.50214C0 0.671185 0.676996 0 1.51165 0ZM1.51165 14.887H25.7369C26.5715 14.887 27.2504 15.5599 27.2504 16.3874V19.058C27.2504 19.8854 26.5716 20.5566 25.7369 20.5566H1.51165C0.676996 20.5566 0 19.8854 0 19.058V16.3874C0 15.5599 0.676996 14.887 1.51165 14.887ZM15.1376 22.3304H1.51165C0.676996 22.3304 0 23.0016 0 23.8309V26.4997C0 27.3272 0.676996 28 1.51165 28H15.1377C15.9759 28 16.6511 27.3272 16.6511 26.4997V23.8309C16.6511 23.0016 15.9759 22.3304 15.1376 22.3304ZM1.51165 7.44171H27.2504C28.0868 7.44171 28.7619 8.11469 28.7619 8.94379V11.6127C28.7619 12.4401 28.0868 13.1148 27.2504 13.1148H1.51165C0.676996 13.1148 0 12.4401 0 11.6127V8.94379C0 8.11469 0.676996 7.44171 1.51165 7.44171Z" fill="#09A5DB"></path></svg>

<img src="art/example.png" height="100" alt="Paystack client example">
    <p align="center">
        <a href="https://github.com/MusheAbdulHakim//actions"><img alt="GitHub Workflow Status (master)" src="https://github.com/MusheAbdulHakim/paystack/actions/workflows/tests.yml/badge.svg"></a>
        <a href="https://packagist.org/packages/musheabdulhakim/paystack"><img alt="Total Downloads" src="https://img.shields.io/packagist/dt/musheabdulhakim/paystack"></a>
        <a href="https://packagist.org/packages/musheabdulhakim/paystack"><img alt="Latest Version" src="https://img.shields.io/packagist/v/musheabdulhakim/paystack"></a>
        <a href="https://packagist.org/packages/musheabdulhakim/paystack"><img alt="License" src="https://img.shields.io/packagist/l/musheabdulhakim/paystack"></a>
    </p>
</div>


------

## Requirement
> **Requires [Composer](https://getcomposer.org/)**
> **Requires [PHP 8.2+](https://php.net/releases/)**
# Paystack PHP SDK

A robust, fluent and object-oriented PHP SDK for the [Paystack API](https://paystack.com/docs), designed for ease of use and extensibility.

---


## Table of Contents

* [Introduction](#introduction)
* [Key Features](#key-features)
* [Installation](#installation)
* [Quick Start](#quick-start)
* [API Reference](#api-reference)
* [Extending the SDK](#extending-the-sdk)
* [Contributing](#contributing)
* [License](#license)

---

## Introduction

The SDK provides a comprehensive and intuitive way to interact with the [Paystack API](https://paystack.com/docs/api/). Designed with developer experience in mind, it offers a fluent, object-oriented interface to various Paystack endpoints, making payment integration seamless and efficient for your PHP applications.

This SDK supports a wide array of Paystack services, including:

* **Transactions:** Initialize, verify, list, fetch, charge authorizations, refunds, and more.
* **Customers:** Manage customer records, including creation, updates, and identity validation.
* **Transfers:** Facilitate single and bulk transfers to bank accounts and mobile money wallets.
* **Subscriptions:** Handle recurring payments by managing plans and customer subscriptions.
* **Dedicated Accounts (Virtual Accounts):** Create and manage unique bank accounts for customers.
* **Transaction Splits:** Automatically divide payments among multiple recipients.
* **Terminals:** Interact with physical Paystack POS devices.
* **Disputes:** Manage and resolve chargebacks effectively.
* **Miscellaneous:** Access general data like lists of banks, countries, and states.

---

## Key Features

* **Fluent API:** Enjoy a clean and readable codebase with chained method calls (e.g., `client()->transaction()->initialize(...)`).
* **Object-Oriented Design:** Paystack API endpoints are encapsulated into dedicated classes for better organization and maintainability.
* **PSR-18 HTTP Client Support:** Leverage any PSR-18 compatible HTTP client for flexible and robust request handling.
* **Strong Typing:** Benefits from PHP's type hints for enhanced code quality and improved IDE support.
* **Extensible Architecture:** Designed for easy extension, allowing you to add custom transporters or build new API modules.

---

## Installation

The easiest way to install the Paystack PHP SDK is via Composer:

```bash
composer require musheabdulhakim/paystack
````

-----

## Quick Start

To get started, initialize the Paystack client with your secret key. You can then immediately begin interacting with any available Paystack API endpoint.

#### Simple Initialization

```php
<?php

require 'vendor/autoload.php';

use MusheAbdulHakim\Paystack\Paystack;

// Replace with your actual Paystack secret key
$secretKey = 'sk_test_xxxxxxxxxxxxxxxxxxxxxxxxxxxx';

// Initialize the Paystack client
$client = Paystack::client($secretKey);

// Example: Initialize a new transaction
try {
    $response = $client->transaction()->initialize([
        'amount' => 500000, // Amount in kobo (e.g., NGN 5000.00)
        'email' => 'customer@example.com',
        'callback_url' => '[https://yourwebsite.com/verify-payment](https://yourwebsite.com/verify-payment)',
    ]);

    echo "Transaction initialized successfully! Authorization URL: " . $response['authorization_url'] . "\n";
} catch (\Exception $e) {
    echo "Error initializing transaction: " . $e->getMessage() . "\n";
}

// Example: List all customers
try {
    $customers = $client->customer()->list(['perPage' => 5]);
    echo "Customers:\n";
    print_r($customers);
} catch (\Exception $e) {
    echo "Error listing customers: " . $e->getMessage() . "\n";
}

?>
```

#### Advanced Initialization with Factory

For more granular control over the underlying HTTP client, base URI, or default headers, use the `Paystack::factory()` method. This is useful for advanced scenarios like proxying requests, custom logging, or integrating with a specific PSR-18 client implementation (e.g., Guzzle).

```php
<?php

require 'vendor/autoload.php';

use MusheAbdulHakim\Paystack\Paystack;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;

// Replace with your actual Paystack secret key
$secretKey = 'sk_test_xxxxxxxxxxxxxxxxxxxxxxxxxxxx';

// Example of a dummy PSR-18 HTTP Client (replace with a real implementation like Guzzle)
class MyCustomHttpClient implements ClientInterface {
    public function sendRequest(\Psr\Http\Message\RequestInterface $request): \Psr\Http\Message\ResponseInterface {
        // Dummy response for demonstration
        return new \GuzzleHttp\Psr7\Response(200, [], '{"status": true, "message": "Custom client response"}');
    }
}

// Example of a dummy PSR-17 Request Factory
class MyCustomRequestFactory implements RequestFactoryInterface {
    public function createRequest(string $method, \Psr\Http\Message\UriInterface|string $uri): \Psr\Http\Message\RequestInterface {
        return new \GuzzleHttp\Psr7\Request($method, $uri);
    }
}

// Example of a dummy PSR-17 Stream Factory
class MyCustomStreamFactory implements StreamFactoryInterface {
    public function createStream(string $content = ''): \Psr\Http\Message\StreamInterface {
        return \GuzzleHttp\Psr7\Utils::streamFor($content);
    }
}

$client = Paystack::factory()
    ->withSecretKey($secretKey)
    ->withBaseUri('[https://api.paystack.com/](https://api.paystack.com/)') // Set a custom base URI
    ->withHeaders([ // Add default headers to all requests
        'X-Custom-Header' => 'My-App-Identifier',
        'User-Agent' => 'MyCustomPaystackClient/1.0',
    ])
    ->withQueryParameters(['perPage' => 50]) // Add default query parameters
    ->withHttpClient(new MyCustomHttpClient()) // Provide your custom HTTP client
    ->withRequestFactory(new MyCustomRequestFactory()) // Provide your custom request factory
    ->withStreamFactory(new MyCustomStreamFactory()) // Provide your custom stream factory
    ->make();

// Now, all requests made through $client will use your custom configurations.
try {
    $response = $client->miscellaneous()->banks(['country' => 'nigeria']);
    echo "Nigerian Banks (via custom client):\n";
    print_r($response);
} catch (\Exception $e) {
    echo "Error fetching banks: " . $e->getMessage() . "\n";
}

?>
```

-----

## API Reference

The SDK is structured with dedicated classes for each major Paystack API resource, providing clear and organized access to their respective methods. Click on the links below to view detailed documentation and sample code for each class.

  * **[Apple Pay](./docs/ApplePay.md)**: Manage Apple Pay domains (register, list, unregister).
  * **[Bulk Charges](./docs/BulkCharge.md)**: Initiate, list, fetch, pause, and resume bulk charge operations.
  * **[Charges](./docs/Charge.md)**: Directly charge customers, handle authentication steps (PIN, OTP, etc.), and check pending charge status.
  * **[Customers](./docs/Customer.md)**: Create, list, fetch, update, validate customer details, and manage risk actions.
  * **[Disputes](./docs/Dispute.md)**: List, fetch, update, resolve disputes, and upload/manage evidence.
  * **[Integration](./docs/Integration.md)**: Fetch and update payment session timeout settings.
  * **[Miscellaneous](./docs/Miscellaneous.md)**: Retrieve lists of banks, countries, and states.
  * **[Payment Pages](./docs/PaymentPage.md)**: Create, list, fetch, update payment pages, check slug availability, and add products.
  * **[Payment Requests](./docs/PaymentRequest.md)**: Create, list, fetch, verify, notify, finalize, update, and archive payment requests (invoices).
  * **[Plans](./docs/Plan.md)**: Create, list, fetch, and update subscription plans.
  * **[Products](./docs/Product.md)**: Create, list, fetch, and update products.
  * **[Refunds](./docs/Refund.md)**: Create, list, and fetch details of refunds for transactions.
  * **[Settlements](./docs/Settlement.md)**: List settlements and retrieve transactions associated with them.
  * **[Subaccounts](./docs/SubAccount.md)**: Create, list, fetch, and update subaccounts for splitting payments.
  * **[Subscriptions](./docs/Subscription.md)**: Create, list, fetch, enable, disable subscriptions, and generate/send management links.
  * **[Terminals](./docs/Terminal.md)**: Send events to terminals, check event status, get terminal presence, list, fetch, update, commission, and decommission devices.
  * **[Transactions](./docs/Transaction.md)**: Initialize, verify, list, fetch transactions, charge authorizations, view timelines, get totals, export data, and perform partial debits.
  * **[Transaction Splits](./docs/TransactionSplit.md)**: Create, list, fetch, update transaction splits, and manage subaccounts within a split.
  * **[Transfers](./docs/Transfer.md)**: Initiate single and bulk transfers, finalize transfers with OTP, list, fetch, and verify status.
  * **[Transfer Control](./docs/TransferControl.md)**: Retrieve account balance and ledger, and manage OTP settings for transfers.
  * **[Transfer Recipients](./docs/TransferRecipient.md)**: Create single and bulk transfer recipients, list, fetch, update, and delete them.
  * **[Verifications](./docs/Verification.md)**: Resolve bank accounts, validate bank accounts, and resolve card BINs.
  * **[Virtual Accounts](./docs/VirtualAccount.md)**: Create, assign, list, fetch, requery, deactivate virtual accounts, manage split transactions, and retrieve bank providers.

-----

## Extending the SDK

The SDK is built with extensibility at its core. If you need to customize how HTTP requests are sent (e.g., for specific logging, advanced error handling, or integrating with a custom HTTP client not directly supported by PSR-18), you can implement your own `Transporter` and provide it to the `Factory`. This allows you to tailor the SDK's behavior to your exact needs.

You can also easily add new API modules if Paystack introduces new endpoints not yet covered by the SDK, or if you wish to group specific functionalities into your own custom classes.

-----

## Contributing

We welcome contributions to the Paystack PHP SDK\! Whether it's bug reports, feature requests, or pull requests, your input is valuable. Please refer to the [CONTRIBUTING.md](./CONTRIBUTING.md) file (if available) for guidelines on how to contribute.

-----

## License

This Paystack PHP SDK is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
