<?php

// Run on console:
// php -f .\sample\address-api\AddressBalanceEndpoint.php

require __DIR__ . '/../bootstrap.php';

use BlockCypher\Api\Address;
use BlockCypher\Auth\SimpleTokenCredential;
use BlockCypher\Rest\ApiContext;

$apiContext = ApiContext::create(
    'main', 'btc', 'v1',
    new SimpleTokenCredential('c0afcccdde5081d6429de37d16166ead'),
    array('log.LogEnabled' => true, 'log.FileName' => 'BlockCypher.log', 'log.LogLevel' => 'DEBUG')
);

$addressBalance = Address::getOnlyBalance('1DEP8i3QJCsomS4BSMY2RpU1upv62aGvhD', array(), $apiContext);

ResultPrinter::printResult("Get Only Address Balance", "Address Balance", $addressBalance->getAddress(), null, $addressBalance);