<?php

// # Create BlockCypher Test Address Sample
// This sample code demonstrate how you can create
// an address.

require __DIR__ . '/../bootstrap.php';

$addressKeyChain = null;

// For Sample Purposes Only.
$request = null;

$addressClient = new \BlockCypher\Client\AddressClient($apiContexts['BCY.test']);

try {
    $addressKeyChain = $addressClient->generateAddress();
} catch (Exception $ex) {
    ResultPrinter::printError("Create BlockCypher Test Address", "AddressKeyChain", null, $request, $ex);
    exit(1);
}

ResultPrinter::printResult("Create BlockCypher Test Address", "AddressKeyChain", $addressKeyChain->getAddress(), $request, $addressKeyChain);

return $addressKeyChain;