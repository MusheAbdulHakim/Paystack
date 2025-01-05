### Verification

```php
use MusheAbdulHakim\Paystack\Paystack;

$paystack = Paystack::client('secret_key');
$verification = $paystack->verification();

```

#### Resolve Account


```php
$response = $verification->resolveAccount($account_number, $bank_code);
```


#### Validate Account

```php
$response = $verification->validateAccount([
    // parameters
]);
```


#### Resolve Card BIN

```php
$response = $verification->resolveCard($bin);
```