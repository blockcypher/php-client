<?php

// php -f .\sample\address-api\generate-address-endpoint.php

require __DIR__ . '/../bootstrap.php';

use BlockCypher\Api\AddressKeyChain;
use BlockCypher\Auth\SimpleTokenCredential;
use BlockCypher\Rest\ApiContext;

$apiContext = ApiContext::create(
    'main', 'btc', 'v1',
    new SimpleTokenCredential('c0afcccdde5081d6429de37d16166ead')
);

$addressKeyChain = new AddressKeyChain();

// For Sample Purposes Only.
$request = clone $addressKeyChain;

$addressKeyChain->create($apiContexts['BTC.main']);

ResultPrinter::printResult("Create Multisig Address", "AddressKeyChain", $addressKeyChain->getAddress(), $request, $addressKeyChain);