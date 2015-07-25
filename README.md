# PHP REST API SDK for BlockCypher

![Home Image](https://raw.githubusercontent.com/wiki/blockcypher/php-client/images/homepage.jpg)

[![Build Status](https://travis-ci.org/blockcypher/php-client.svg)](https://travis-ci.org/blockcypher/php-client) 
[![Coverage Status](https://coveralls.io/repos/blockcypher/php-client/badge.svg?branch=master)](https://coveralls.io/r/blockcypher/php-client?branch=master)

__Welcome to BlockCypher PHP SDK__. This repository contains BlockCypher's PHP SDK and samples for REST API.

## SDK Documentation

[ Our BlockCypher-PHP-SDK Page ](http://blockcypher.github.io/php-client/) includes all the documentation related to PHP SDK. Everything from SDK Wiki, to Sample Codes, to Releases. Here are few quick links to get you there faster.

* [ BlockCypher-PHP-SDK Home Page ](http://blockcypher.github.io/php-client/)
* [ Wiki ](https://github.com/blockcypher/php-client/wiki)
* [ Samples ](http://blockcypher.github.io/php-client/sample/)
* [ PHP wallet sample](https://github.com/blockcypher/php-wallet-sample)
* [ Installation ](https://github.com/blockcypher/php-client/wiki/Installation)
* [ Make your First SDK Call](https://github.com/blockcypher/php-client/wiki/Making-First-Call)
* [ BlockCypher Developer Docs] (http://dev.blockcypher.com/)

## Prerequisites

   - PHP 5.4+
   - [curl](http://php.net/manual/en/book.curl.php), [json](http://php.net/manual/en/book.json.php) & [openssl](http://php.net/manual/en/book.openssl.php) extensions must be enabled
   - [ext-gmp](http://php.net/manual/en/book.gmp.php)
   - [ext-mcrypt](http://php.net/manual/es/book.mcrypt.php)

## More help
   * [Going Live](https://github.com/blockcypher/php-client/wiki/Going-Live)
   * [BlockCypher-PHP-SDK Home Page](http://blockcypher.github.io/php-client/)
   * [SDK Documentation](https://github.com/blockcypher/php-client/wiki)
   * [Sample Source Code](http://blockcypher.github.io/php-client/sample/)
   * [API Reference](http://dev.blockcypher.com/)
   * [Reporting Issues / Feature Requests] (https://github.com/blockcypher/php-client/issues)
   
## Upcoming features

###Currently unavailable/upcoming REST API features

   * Install from phar
   
###New samples

   - Capturing callback sample.
   - Managing errors in batching requests.
   
## Quick Examples

### Setup ApiContext

```php
<?php
// Autoload the SDK Package. Installed via direct download.
require __DIR__  . '/php-client/autoload.php';
// Require the Composer autoloader. Installed via composer
//require 'vendor/autoload.php';

use BlockCypher\Auth\SimpleTokenCredential;
use BlockCypher\Rest\ApiContext;
use BlockCypher\Api\Address;

// Provide your Token. Replace the given one with your app Token
// https://accounts.blockcypher.com/dashboard
$token = 'c0afcccdde5081d6429de37d16166ead';

// SDK config
$config = array(
    'mode' => 'sandbox',
    'log.LogEnabled' => true,
    'log.FileName' => 'BlockCypher.log',
    'log.LogLevel' => 'DEBUG', // PLEASE USE 'INFO' LEVEL FOR LOGGING IN LIVE ENVIRONMENTS
    'validation.level' => 'log',
);

$apiContext = ApiContext::create(
    'main', 'btc', 'v1',
    new SimpleTokenCredential('c0afcccdde5081d6429de37d16166ead'),
    $config
);
```

### Get Address info

```php
<?php
use BlockCypher\Api\Address;

$addressClient = new AddressClient($apiContext);
$address = $addressClient->get('1DEP8i3QJCsomS4BSMY2RpU1upv62aGvhD');

echo "JSON Address: " . $address->toJson() . "\n";
var_dump($address);
```   

### Send a microtransaction

```php
<?php
$microTXClient = new MicroTXClient($apiContext);

try {
    $microTX = $microTXClient->sendSigned(
        "2c2cc015519b79782bd9c5af66f442e808f573714e3c4dc6df7d79c183963cff", // private key
        "C4MYFr4EAdqEeUKxTnPUF3d3whWcPMz1Fi", // to address
        10000 // value (satoshis)
    );
} catch (\Exception $e) {
    echo "There was an error sending the microtx.\n";
}
```   

   
   