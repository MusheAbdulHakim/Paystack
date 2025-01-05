### Miscellaneous

```php
use MusheAbdulHakim\Paystack\Paystack;

$paystack = Paystack::client('secret_key');
$miscellaneous = $paystack->miscellaneous();

```


#### List Banks


```php
$response = $miscellaneous->banks([
    //parameters
]);
```


#### List Countries


```php
$response = $miscellaneous->countries();
```


#### List States (AVS)


```php
$response = $miscellaneous->states([
    //parameters 
]);
```