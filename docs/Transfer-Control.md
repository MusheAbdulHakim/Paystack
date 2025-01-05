### Transfer Control

```php
use MusheAbdulHakim\Paystack\Paystack;

$paystack = Paystack::client('secret_key');
$transferControl = $paystack->transferControl();
```


#### Check Balance

```php
$response = $transferControl->balance();
```


#### Fetch Balance Ledger

```php
$response = $transferControl->ledger();
```


#### Resend OTP

```php
$response = $transferControl->resendOTP($transfer_code, $reason);
```


#### Disable OTP

```php
$response = $transferControl->disableOTP();
```


#### Disable OTP

```php
$response = $transferControl->finalizeDisableOTP('otp');
```


#### Enable OTP

```php
$response = $transferControl->enableOTP();
```