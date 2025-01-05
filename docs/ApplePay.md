### Transfer Control

```php
use MusheAbdulHakim\Paystack\Paystack;

$paystack = Paystack::client('secret_key');
$applepay = $paystack->applePay();
```


#### Register Domain

```php
$response = $applepay->register($domainName);
```

#### List Domains

```php
$response = $applepay->list([
    // parameters
]);
```

#### Unregister Domain


```php
$response = $applepay->unregister($domainName);
```