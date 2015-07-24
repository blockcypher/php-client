<?php

// Run on console:
// php -f .\sample\address-api\GenerateMultisigAddressEndpoint.php

require __DIR__ . '/../bootstrap.php';

use BlockCypher\Api\AddressKeyChain;
use BlockCypher\Auth\SimpleTokenCredential;
use BlockCypher\Client\AddressClient;
use BlockCypher\Rest\ApiContext;

$apiContext = ApiContext::create(
    'main', 'btc', 'v1',
    new SimpleTokenCredential('c0afcccdde5081d6429de37d16166ead'),
    array('mode' => 'sandbox', 'log.LogEnabled' => true, 'log.FileName' => 'BlockCypher.log', 'log.LogLevel' => 'DEBUG')
);

$addressClient = new AddressClient($apiContext);
$pubkeys = array(
    "02c716d071a76cbf0d29c29cacfec76e0ef8116b37389fb7a3e76d6d32cf59f4d3",
    "033ef4d5165637d99b673bcdbb7ead359cee6afd7aaf78d3da9d2392ee4102c8ea",
    "022b8934cc41e76cb4286b9f3ed57e2d27798395b04dd23711981a77dc216df8ca"
);
$addressKeyChain = $addressClient->generateMultisigAddress($pubkeys, 'multisig-2-of-3');

// For Sample Purposes Only.
$request = new AddressKeyChain();
$request->setPubkeys($pubkeys);
$request->setScriptType('multisig-2-of-3');

ResultPrinter::printResult("Create Multisig Address", "AddressKeyChain", $addressKeyChain->getAddress(), $request, $addressKeyChain);