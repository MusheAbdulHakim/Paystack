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


2. If you don't want to use .env file, you can set the values by passing them to the initialized class. 
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





<a name="Customization"></a>
## Customization
1. You can override the Client class and use your own http client



## Test

To run the tests, run the following command from the project folder.

``` bash
$ ./vendor/bin/phpunit
```





## License

The MIT License (MIT). See the [License File](https://github.com/MusheAbdulHakim/Paystack/blob/master/LICENSE) for more information.
