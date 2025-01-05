### Customer
```php
use MusheAbdulHakim\Paystack\Paystack;

$paystack = Paystack::client('secret_key');
$customer = $paystack->customer();
```


#### Create Customer
```php
$response = $customer->create([
    // parameters
]);
```


#### List Customers

```php
$response = $customer->list([
    // parameters (optional)
]);
```


#### Fetch Customer


```php
$response = $customer->fetch('emailOrCode');
```


#### Update Customer


```php
$response = $customer->update('code', [
    //parameters
]);
```

#### Validate Customer


```php
$response = $customer->validate('code',[
    //parameters
]);
```

#### Whitelist/Blacklist Customer


```php
$action = 'allow'; // or 'deny'
$response = $customer->status('customer',$action);
```

#### Blacklist Customer


```php
$response = $customer->blackList('customer');
```

#### Whitelist Customer


```php
$response = $customer->whiteList('customer');
```

#### Deactivate Authorization



```php
$response = $customer->deactivate('code');
```

