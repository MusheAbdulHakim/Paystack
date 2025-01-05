### Integration

```php
use MusheAbdulHakim\Paystack\Paystack;

$paystack = Paystack::client('secret_key');
$integration = $paystack->integration();
```



#### Fetch Timeout

```php
$response = $integration->fetchPayment();
```


#### Update Timeout


```php
$timeout = 30;
$response = $integration->updatePayment($timeout);
```