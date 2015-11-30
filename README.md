# php-moneris-eselectplus
A much less awful and modern way to access the Moneris eSELECTplus API.
This library was initially a fork of [ironkeith/moneris-eselectplus-api](https://github.com/cedricblondeau/moneris-eselectplus-api/tree/dev).

## Usage example
```php
// Config
$config = new \CedricBlondeau\Moneris\Config(array(
    'api_key' => 'yesguy',
    'store_id' => 'store1',
    'environment' => Config::ENV_TESTING
));

// Purchase transaction
$transaction = new \CedricBlondeau\Moneris\Transaction\Basic\Purchase($config, array(
    'cc_number' => '4242424242424242',
    'expiry_month' => 10,
    'expiry_year' => 18,
    'order_id' => 'test' . date("dmy-G:i:s"),
    'amount' => 100
));

// CURL
$httpClient = new \CedricBlondeau\Moneris\Http\Client\Curl($transaction);
$result = $httpClient->execute();
```