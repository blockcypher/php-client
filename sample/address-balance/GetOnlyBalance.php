<?php

// # Get Only Balance Sample
// This method allows you to
// retrieve only balance and number of transactions for a given address/wallet.
// API called: '/v1/btc/main/addrs/1DEP8i3QJCsomS4BSMY2RpU1upv62aGvhD/balance'

require __DIR__ . '/../bootstrap.php';

// The following code takes you through
// the process of retrieving balance and number of transactions about this address 1DEP8i3QJCsomS4BSMY2RpU1upv62aGvhD

/// ### Retrieve this address 1DEP8i3QJCsomS4BSMY2RpU1upv62aGvhD balance
// (See bootstrap.php for more on `ApiContext`)
try {
    $addressBalance = \BlockCypher\Api\AddressBalance::get('1DEP8i3QJCsomS4BSMY2RpU1upv62aGvhD', array(), $apiContext);
} catch (Exception $ex) {
    ResultPrinter::printError("Get Only Address Balance", "Address Balance", '1DEP8i3QJCsomS4BSMY2RpU1upv62aGvhD', null, $ex);
    exit(1);
}

ResultPrinter::printResult("Get Only Address Balance", "Address Balance", $addressBalance->getAddress(), null, $addressBalance);

return $addressBalance;