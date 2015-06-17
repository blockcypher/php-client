<?php

// # Generate new test BCY address
// API called: '/v1/bcy/test'

require __DIR__ . '/../bootstrap.php';

// An AddressKeyChain represents an associated collection of public and
// private keys alongside their respective public address.
$addressKeyChain = new \BlockCypher\Api\AddressKeyChain();

// Clone request object for sample purposes only.
$request = clone $addressKeyChain;

// (See bootstrap.php for more on `ApiContext`)
try {
    /// ### Create new test BCY Address
    $addressKeyChain->create($apiContexts['BCY.test']);
} catch (Exception $ex) {
    ResultPrinter::printError("Generate Test Bcy Address", "AddressKeyChain", null, $request, $ex);
    exit(1);
}

ResultPrinter::printResult("Generate Test Bcy Address", "AddressKeyChain", $addressKeyChain->getAddress(), $request, $addressKeyChain);

return $addressKeyChain;