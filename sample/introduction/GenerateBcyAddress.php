<?php

// Docs site sample
// php -f .\sample\introduction\GenerateBcyAddress.php

require __DIR__ . '/../bootstrap.php';

use BlockCypher\Api\AddressKeyChain;
use BlockCypher\Auth\SimpleTokenCredential;
use BlockCypher\Rest\ApiContext;

$apiContext = ApiContext::create(
    'test', 'bcy', 'v1',
    new SimpleTokenCredential('c0afcccdde5081d6429de37d16166ead')
);

$addressKeyChain = new AddressKeyChain();

// For Sample Purposes Only.
$request = clone $addressKeyChain;

$addressKeyChain->create($apiContexts['BCY.test']);

ResultPrinter::printResult("Create Multisig Address", "AddressKeyChain", $addressKeyChain->getAddress(), $request, $addressKeyChain);