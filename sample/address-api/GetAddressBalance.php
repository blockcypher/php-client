<?php

// # Get Address Balance Sample
// This method allows you to
// retrieve only balance for a given address/wallet.
// API called: '/v1/btc/main/addrs/1DEP8i3QJCsomS4BSMY2RpU1upv62aGvhD/balance'

require __DIR__ . '/../bootstrap.php';

// The following code takes you through
// the process of retrieving balance about this address 1DEP8i3QJCsomS4BSMY2RpU1upv62aGvhD

$addressClient = new \BlockCypher\Client\AddressClient($apiContexts['BTC.main']);

try {
    $addressBalance = $addressClient->getBalance('1DEP8i3QJCsomS4BSMY2RpU1upv62aGvhD');
} catch (Exception $ex) {
    ResultPrinter::printError("Get Only Address Balance", "Address Balance", '1DEP8i3QJCsomS4BSMY2RpU1upv62aGvhD', null, $ex);
    exit(1);
}

ResultPrinter::printResult("Get Only Address Balance", "Address Balance", $addressBalance->getAddress(), null, $addressBalance);

return $addressBalance;