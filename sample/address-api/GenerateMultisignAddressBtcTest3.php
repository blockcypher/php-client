<?php

// # Create Multisig Testnet3 Address Sample
// This sample code demonstrate how you can create
// a multisign address address.

require __DIR__ . '/../bootstrap.php';

$addressKeyChain = new \BlockCypher\Api\AddressKeyChain();
$pubkeys = array(
    "03798be8162d7d6bc5c4e3b236100fcc0dfee899130f84c97d3a49faf83450fd81",
    "03dd9f1d4a39951013b4305bf61887ada66439ab84a9a2f8aca9dc736041f815f1",
    "03c8e6e99c1d0b42120d5cf40c963e5e8048fd2d2a184758784a041a9d101f1f02"
);
$addressKeyChain->setPubkeys($pubkeys);
// script format: 'multisig-n-of-m', where n and m are integers.
$addressKeyChain->setScriptType('multisig-2-of-3');

// For Sample Purposes Only.
$request = clone $addressKeyChain;

try {
    // ### Create Multisig Address
    $output = $addressKeyChain->create($apiContexts['BTC.test3']);
} catch (Exception $ex) {
    ResultPrinter::printError("Create Multisig Address", "AddressKeyChain", null, $request, $ex);
    exit(1);
}

ResultPrinter::printResult("Create Multisig Address", "AddressKeyChain", $addressKeyChain->getAddress(), $request, $output);

return $output;