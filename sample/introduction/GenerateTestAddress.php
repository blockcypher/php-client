<?php

// # Generate New BlockCypher Test Address
//
// API called: '/v1/bcy/test'

require __DIR__ . '/../bootstrap.php';

// An AddressKeyChain represents an associated collection of public and
// private keys alongside their respective public address.
/// For sample purposes only
$addressKeyChain = new \BlockCypher\Api\AddressKeyChain();
$request = clone $addressKeyChain;

$addressClient = new \BlockCypher\Client\AddressClient($apiContexts['BCY.test']);

try {
    /// Create new test BCY Address
    $addressKeyChain = $addressClient->generateAddress();
} catch (Exception $ex) {
    ResultPrinter::printError("Generate Test Bcy Address", "AddressKeyChain", null, $request, $ex);
    exit(1);
}

ResultPrinter::printResult("Generate Test Bcy Address", "AddressKeyChain", $addressKeyChain->getAddress(), $request, $addressKeyChain);

return $addressKeyChain;