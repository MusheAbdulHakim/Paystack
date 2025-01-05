### BulkCharge

```php
use MusheAbdulHakim\Paystack\Paystack;

$paystack = Paystack::client('secret_key');
$bulkcharge = $paystack->bulkCharge();
```

#### Initiate Bulk Charge

```php

$bulkcharge = $paystack->init([
    //parameters
]);
```

#### List Bulk Charge Batches


```php

$bulkcharge = $paystack->list([
    //parameters
]);

```

#### Fetch Bulk Charge Batch


```php

$bulkcharge = $paystack->fetch("id_or_code");

```


#### Fetch Charges in a Batch


```php

$bulkcharge = $paystack->batch("id_or_code",[
    //parameters
]);

```

#### Pause Bulk Charge Batch


```php

$bulkcharge = $paystack->pause("id_or_code");

```

#### Resume Bulk Charge Batch


```php

$bulkcharge = $paystack->resume("id_or_code");

```

