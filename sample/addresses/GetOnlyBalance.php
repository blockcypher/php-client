<?php

// # Get Only Balance Sample
// This method allows you to
// retrieve only balance and number of transactions for a given address/wallet.
// API called: '/v1/btc/main/addrs/1DEP8i3QJCsomS4BSMY2RpU1upv62aGvhD/balance'

require __DIR__ . '/../bootstrap.php';

// The following code takes you through
// the process of retrieving balance and number of transactions about this address 1DEP8i3QJCsomS4BSMY2RpU1upv62aGvhD

// override default sample address with GET parameter
if (isset($_GET['address'])) {
    $sampleAddress = filter_input(INPUT_GET, 'address', FILTER_SANITIZE_SPECIAL_CHARS);
} else {
    $sampleAddress = '1DEP8i3QJCsomS4BSMY2RpU1upv62aGvhD'; // Default address for samples
}

/// ### Retrieve this address 1DEP8i3QJCsomS4BSMY2RpU1upv62aGvhD balance
// (See bootstrap.php for more on `ApiContext`)
try {
    $addressBalance = \BlockCypher\Api\Address::getOnlyBalance($sampleAddress, array(), $apiContexts['BTC.main']);
} catch (Exception $ex) {
    ResultPrinter::printError("Get Only Address Balance", "Address Balance", $sampleAddress, null, $ex);
    exit(1);
}

ResultPrinter::printResult("Get Only Address Balance", "Address Balance", $addressBalance->getAddress(), null, $addressBalance);

return $addressBalance;