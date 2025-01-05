## Home


```php

use MusheAbdulHakim\Paystack\Paystack;

$paystack = Paystack::client(
    "xxxxxxxx_secret_key",
    "api_url" // optional
    );

    // Or

$paystack = Paystack::init(
    "xxxxxxxx_secret_key",
    )
    ->withBaseUri(
        'api_url' // optional
        )
    ->withHttpClient(
        // HttpClient . The default is Guzzle
    );

```