### Charges

```php
use MusheAbdulHakim\Paystack\Paystack;

$paystack = Paystack::client('secret_key');
$charges = $paystack->charge();
```

#### Create Charge

```php
$response = $charges->create($email, $amount, [
    //parameters
]);
```

#### Submit PIN 

```php
$response = $charges->submitPin($pin, $reference);
```


#### Submit OTP

```php
$response = $charges->submitOTP($otp, $reference);
```


#### Submit Phone

```php
$response = $charges->submitPhone($phone, $reference);
```


#### Submit Birthday

```php
$response = $charges->submitBirthday($birthday, $reference);
```


#### Submit Address

```php
$response = $charges->submitAddress([
    //parameters
]);
```


#### Check Pending Charge 

```php
$response = $charges->checkPending($reference);
```
