<?php

// # Get Full Address Sample
// This method allows you to
// retrieve all details about a given address/wallet, including full transaction information.
// API called: '/v1/btc/main/addrs/1DEP8i3QJCsomS4BSMY2RpU1upv62aGvhD/full'

require __DIR__ . '/../bootstrap.php';

// The following code takes you through
// the process of retrieving all details about this address 1DEP8i3QJCsomS4BSMY2RpU1upv62aGvhD

$addressClient = new \BlockCypher\Client\AddressClient($apiContexts['BTC.main']);

try {
    $fullAddress = $addressClient->getFullAddress('1DEP8i3QJCsomS4BSMY2RpU1upv62aGvhD');
} catch (Exception $ex) {
    ResultPrinter::printError("Get Full Address", "Full Address", '1DEP8i3QJCsomS4BSMY2RpU1upv62aGvhD', null, $ex);
    exit(1);
}

ResultPrinter::printResult("Get Full Address", "Full Address", $fullAddress->getAddress(), null, $fullAddress);

return $fullAddress;