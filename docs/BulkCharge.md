### BulkCharge

```php
use MusheAbdulHakim\Paystack\Paystack;

$paystack = Paystack::client('secret_key');
$response = $bulkcharge->bulkCharge();
```

#### Initiate Bulk Charge

```php

$response = $bulkcharge->init([
    //parameters
]);
```

#### List Bulk Charge Batches


```php

$response = $bulkcharge->list([
    //parameters
]);

```

#### Fetch Bulk Charge Batch


```php

$response = $bulkcharge->fetch("id_or_code");

```


#### Fetch Charges in a Batch


```php

$response = $bulkcharge->batch("id_or_code",[
    //parameters
]);

```

#### Pause Bulk Charge Batch


```php

$response = $bulkcharge->pause("id_or_code");

```

#### Resume Bulk Charge Batch


```php

$response = $bulkcharge->resume("id_or_code");

```

