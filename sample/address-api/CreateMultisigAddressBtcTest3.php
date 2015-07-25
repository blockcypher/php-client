<?php

// # Create Multisig Testnet3 Address Sample
// This sample code demonstrate how you can create
// a multisig address address.

require __DIR__ . '/../bootstrap.php';

// BTC-TESTNET: 2NBbY8fbHRLjWXHqRvs8P996N82eTYic1yX
$pubkeys = array(
    "033e88a5503dc09243e58d9e7a53831c2b77cac014415ad8c29cabab5d933894c1",
    "02087f346641256d4ba19cc0473afaa8d3d1b903761b9220a915e1af65a12e613c",
    "03051fa1586ff8d509125d3e25308b4c66fcf656b377bf60bfdb296a4898d42efd"
);

// For Sample Purposes Only.
$request = new \BlockCypher\Api\AddressKeyChain();
$request->setPubkeys($pubkeys);
$request->setScriptType('multisig-2-of-3'); // script format: 'multisig-n-of-m', where n and m are integers.

$addressClient = new \BlockCypher\Client\AddressClient($apiContexts['BTC.test3']);

try {
    // ### Create Multisig Address
    $output = $addressClient->generateMultisigAddress($pubkeys, 'multisig-2-of-3');
} catch (Exception $ex) {
    ResultPrinter::printError("Create Multisig Address", "AddressKeyChain", null, $request, $ex);
    exit(1);
}

ResultPrinter::printResult("Create Multisig Address", "AddressKeyChain", $addressKeyChain->getAddress(), $request, $output);

return $output;