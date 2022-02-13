# php-moneris-eselectplus [![Build Status](https://travis-ci.org/cedricblondeau/php-moneris-eselectplus.svg)](https://travis-ci.org/cedricblondeau/php-moneris-eselectplus)
An alternative and modern way to access the Moneris eSELECTplus API with PHP 5.3+.

This library was initially a fork of [ironkeith/moneris-eselectplus-api](https://github.com/ironkeith/moneris-eselectplus-api).

### Motivation
I needed to integrate Moneris with a nice and modern PHP project and did not want to include the source code they provide.

[Keith Silgard](https://github.com/ironkeith) did an awesome job by writing an [alternative library](https://github.com/ironkeith/moneris-eselectplus-api) but I wanted something with namespaces, PSR-4 support, unit testing and Vault API functions, so I decided to fork it and finally, to fully redesign and rewrite it for PHP 5.3+.

### Usage example
```php
use CedricBlondeau\Moneris;

// Config
$config = new Config('test_api_key', 'store1');
$config->setEnvironment(Config::ENV_TESTING);

// Purchase transaction
$transaction = new Moneris\Transaction\Basic\Purchase($config, array(
    'cc_number' => '4242424242424242',
    'expiry_month' => 10,
    'expiry_year' => 18,
    'order_id' => 'test' . date("dmy-G:i:s"),
    'amount' => 100
));

// CURL
$httpClient = new Moneris\Http\Client\Curl($transaction);
$result = $httpClient->execute();
```
