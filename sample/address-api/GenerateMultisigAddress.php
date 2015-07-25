<?php

// # Generate Multisig Address
// This sample code demonstrate how you can generate a multisig address address.

require __DIR__ . '/../bootstrap.php';

$addressClient = new \BlockCypher\Client\AddressClient($apiContexts['BTC.main']);

$pubkeys = array(
    "02c716d071a76cbf0d29c29cacfec76e0ef8116b37389fb7a3e76d6d32cf59f4d3",
    "033ef4d5165637d99b673bcdbb7ead359cee6afd7aaf78d3da9d2392ee4102c8ea",
    "022b8934cc41e76cb4286b9f3ed57e2d27798395b04dd23711981a77dc216df8ca"
);

/// For Sample Purposes Only.
$addressKeyChain = new \BlockCypher\Api\AddressKeyChain();
$addressKeyChain->setPubkeys($pubkeys);
$addressKeyChain->setScriptType('multisig-2-of-3');
$request = clone $addressKeyChain;

try {
    $output = $addressClient->generateMultisigAddress($pubkeys, 'multisig-2-of-3');
} catch (Exception $ex) {
    ResultPrinter::printError("Generate Multisig Address", "AddressKeyChain", null, $request, $ex);
    exit(1);
}

ResultPrinter::printResult("Generate Multisig Address", "AddressKeyChain", $addressKeyChain->getAddress(), $request, $output);

return $output;