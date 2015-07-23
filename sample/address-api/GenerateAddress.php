<?php

// # Generate Address
// This sample code demonstrate how you can generate an address.
//
// API called: '/v1/btc/main/addrs'

require __DIR__ . '/../bootstrap.php';

$addressClient = new \BlockCypher\Client\AddressClient($apiContexts['BTC.main']);

try {
    $addressKeyChain = $addressClient->generateAddress();
} catch (Exception $ex) {
    ResultPrinter::printError("Generate Address", "AddressKeyChain", null, null, $ex);
    exit(1);
}

ResultPrinter::printResult("Generate Address", "AddressKeyChain", $addressKeyChain->getAddress(), null, $addressKeyChain);

return $addressKeyChain;