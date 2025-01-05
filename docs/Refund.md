### Refunds

```php
use MusheAbdulHakim\Paystack\Paystack;

$paystack = Paystack::client('secret_key');
$refund = $paystack->refund();

```


#### Create Refund


```php
$response = $refund->create($transaction, [
    //parameters
]);
```


#### List Refunds


```php
$response = $refund->list($transaction,[
    //parameters
]);
```


#### Fetch Refund


```php
$response = $refund->fetch($id);
```