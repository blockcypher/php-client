<?php

// # Generate Testnet3 Address
// This sample code demonstrate how you can generate a Testnet address.

require __DIR__ . '/../bootstrap.php';

$addressClient = new \BlockCypher\Client\AddressClient($apiContexts['BTC.test3']);

// ### Generate BTC Testnet Address
try {
    $addressKeyChain = $addressClient->generateAddress();
} catch (Exception $ex) {
    ResultPrinter::printError("Generate BTC Testnet Address", "AddressKeyChain", null, null, $ex);
    exit(1);
}

ResultPrinter::printResult("Generate BTC Testnet Address", "AddressKeyChain", $addressKeyChain->getAddress(), null, $addressKeyChain);

return $addressKeyChain;