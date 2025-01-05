### Disputes

```php
use MusheAbdulHakim\Paystack\Paystack;

$paystack = Paystack::client('secret_key');
$dispute = $paystack->dispute();

```


#### List Disputes


```php
$response = $dispute->list([
    //parameters
]);
```


#### Fetch Dispute


```php
$response = $dispute->fetch($id);
```


#### List Transaction Disputes


```php
$response = $dispute->transactions($id);
```


#### Update Dispute


```php
$response = $dispute->update($id, [
    //parameters
]);
```


#### Add Evidence


```php
$response = $dispute->evidence($id, [
    //parameters
]);
```


#### Get Upload URL


```php
$response = $dispute->uploadUrl($id, [
    //parameters
]);
```


#### Resolve Dispute


```php
$response = $dispute->resolve($id, [
    //parameters
]);
```


#### Export Disputes



```php
$response = $dispute->export([
    //parameters
]);
```