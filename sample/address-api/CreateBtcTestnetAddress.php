<?php

// # Create Bitcoin Testnet Address Sample
// This sample code demonstrate how you can create
// an address.

require __DIR__ . '/../bootstrap.php';

$addressKeyChain = null;

// For Sample Purposes Only.
$request = null;

$addressClient = new \BlockCypher\Client\AddressClient($apiContexts['BTC.test3']);

try {
    $addressKeyChain = $addressClient->generateAddress();
} catch (Exception $ex) {
    ResultPrinter::printError("Create Btc Testnet Address", "AddressKeyChain", null, $request, $ex);
    exit(1);
}

ResultPrinter::printResult("Create Btc Testnet Address", "AddressKeyChain", $addressKeyChain->getAddress(), $request, $addressKeyChain);

return $addressKeyChain;