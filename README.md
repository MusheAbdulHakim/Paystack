# Paystack

[![Latest Stable Version](https://poser.pugx.org/musheabdulhakim/paystack/v/stable)](https://packagist.org/packages/musheabdulhakim/paystack) 
[![License](https://poser.pugx.org/musheabdulhakim/paystack/license)](https://packagist.org/packages/nextpack/nextpack)







**Paystack** is a PHP & Laravel package, that makes working with [Paystack](https://paystack.com) api a breeze.

> Laravel and Core PHP supported library for Paystack





<a name="Features"></a>
## Features


- Customers

- Transactions

- Transaction Split

- Terminal

- Misc
  





<a name="Installation"></a>
## Installation

1. ### Using Composer
    - 
    ```php
    composer require musheabdulhakim/paystack
    ```
    - 
    ``` php
    require_once __DIR__ . "/vendor/autoload.php";
    ```
    
2. ### Manual
- Download the archive
- Extract into your project
- Run composer
    ```php
    composer install
    ```
- And lastly
    ``` php
    require_once __DIR__ . "/vendor/autoload.php";
    ```

3. ### Clone the repository
    ```php
    git clone https://github.com/MusheAbdulHakim/Paystack.git
    ```

    ```php
    composer install
    ```

    ``` php
    require_once __DIR__ . "/vendor/autoload.php";
    ```
<a name="Usage"></a>
## Usage

## Initialize Paystack 
1. Using ``.env`` file, set the values of your keys
    ```php
    SECRET_KEY = "sk_test_xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx"
    PUBLIC_KEY = "pk_test_xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx"
    MERCHANT_EMAIL = "test@example.com"
    ```

    ```php
        <?php

        use Musheabdulhakim\Paystack\Paystack;

        include_once('./vendor/autoload.php');
        $paystack = new Paystack();
    ```


2. If you don't want to use .env file, you can set the values by passing it to the initialized class. 
    ```php
        <?php

        use Musheabdulhakim\Paystack\Paystack;

        include_once('./vendor/autoload.php');

        $paystack = new Paystack([
            'SECRET_KEY' => 'sk_test_xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx',
            'PUBLIC_KEY' => 'pk_test_xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx',
            'MERCHANT_EMAIL' => 'test@example.com'
        ]);
    ```
<a name="Transaction"></a>
### Transaction

### [Initialize Transaction](https://paystack.com/docs/api/transaction/#initialize)

```
$transaction = $paystack->transaction(
    $email, 
    $amount, 
    [
        // optional parameters
    ]
);

//or

$transaction = $paystack->transaction('test@transaction.com','1000');

//or

$transaction = $paystack->transaction('test@transaction.com','1000',[
    // optional parameters
]);

//or

$paystack->transaction->init(
    $email, 
    $amount, 
    [
        // optional parameters
    ]
);

//or

$params = [
    'email' => "customer@email.com",
    'amount' => "20000",
    'split_code' => 'SPL_98WF13Eb3w'
];
$paystack->transaction->initialize($params);
```

<a name="Verify Transaction"></a>
### Verify Transaction

### [Verify Transaction](https://paystack.com/docs/api/transaction/#verify)

```
$transaction = $paystack->transaction->verify('1vl0abs51p');
$transaction = $paystack->transaction()->verify('1vs0ars51p');

//check the status of the transaction
$transaction_status = $paystack->transaction->verify('1vl0abs51p')["status"];
```

<a name="List Transaction"></a>
### List Transaction

### [List Transaction](https://paystack.com/docs/api/transaction/#list)

```

$transactions = $paystack->transaction->list();
//or 
$transaction = $paystack->transaction()->list();

//pass optional parameters to the list method
$params = [
    'page' => '',
    'customer' => '',
    'terminalid' => ''
];
$transactions = $paystack->transaction->list($params);
```

<a name="Fetch Transaction"></a>
### Fetch Transaction

### [Fetch Transaction](https://paystack.com/docs/api/transaction/#fetch)

```

$transaction = $paystack->transaction->fetch(2745284445);
//or 
$transaction = $paystack->transaction()->fetch(2745284445);

```

<a name="Charge Authorization"></a>
### Charge Authorization

### [Charge Authorization](https://paystack.com/docs/api/transaction/#charge-authorization)

```
$params = [
    //optional parameters
];
$transaction = $paystack->transaction->chargeAuth('test@gmail.com','10000','AUTH_ir6emhfrpk',$params);


```

<a name="View Transaction Timeline"></a>
### View Transaction Timeline


### [View Transaction Timeline](https://paystack.com/docs/api/transaction/#view-timeline)

```

$transaction_timeline = $paystack->transaction->timeline('1vl0abs51p');

```

<a name="Transaction Totals"></a>
### Transaction Totals


### [Transaction Totals](https://paystack.com/docs/api/transaction/#totals)

```
$params [
    // Your query parameters
];

$transation_total = $paystack->transaction->total($params);

```

<a name="Export Transaction"></a>
### Export Transactions

### [Export Transactions](https://paystack.com/docs/api/transaction/#export)

```
$params [
    // Your query parameters
];

$export = $paystack->transaction->export($params);

```


<a name="Partial Debit"></a>
### Partial Debit

### [Partial Debit](https://paystack.com/docs/api/transaction/#partial-debit)

```
$params [
    // Your query parameters
];

$trans = $paystack->transaction->partialDebit($authorization_code, $currency, $amount, $email, $params);

```


<a name="Customization"></a>
## Customization
1. You can override the Client class and use your own http client



## Test

To run the tests, run the following command from the project folder.

``` bash
 ./vendor/bin/phpunit
```





## License

The MIT License (MIT). See the [License File](https://github.com/MusheAbdulHakim/Paystack/blob/master/LICENSE) for more information.
