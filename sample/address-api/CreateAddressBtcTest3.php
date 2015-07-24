<?php

// # Create Testnet3 Address
// This sample code demonstrate how you can create an address.

require __DIR__ . '/../bootstrap.php';

$addressKeyChain = null;

/// For Sample Purposes Only.
$request = null;

$addressClient = new \BlockCypher\Client\AddressClient($apiContexts['BTC.test3']);

// ### Create Address
try {
    $addressKeyChain = $addressClient->generateAddress();
} catch (Exception $ex) {
    ResultPrinter::printError("Create Address", "AddressKeyChain", null, $request, $ex);
    exit(1);
}

ResultPrinter::printResult("Create Address", "AddressKeyChain", $addressKeyChain->getAddress(), $request, $addressKeyChain);

return $addressKeyChain;