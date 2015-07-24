<?php

// Run on console:
// php -f .\sample\address-api\AddressBalanceEndpoint.php

require __DIR__ . '/../bootstrap.php';

use BlockCypher\Auth\SimpleTokenCredential;
use BlockCypher\Client\AddressClient;
use BlockCypher\Rest\ApiContext;

$apiContext = ApiContext::create(
    'main', 'btc', 'v1',
    new SimpleTokenCredential('c0afcccdde5081d6429de37d16166ead'),
    array('mode' => 'sandbox', 'log.LogEnabled' => true, 'log.FileName' => 'BlockCypher.log', 'log.LogLevel' => 'DEBUG')
);

$addressClient = new AddressClient($apiContext);
$addressBalance = $addressClient->getBalance('1DEP8i3QJCsomS4BSMY2RpU1upv62aGvhD');

ResultPrinter::printResult("Get Only Address Balance", "Address Balance", $addressBalance->getAddress(), null, $addressBalance);