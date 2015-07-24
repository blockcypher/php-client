<?php

// # Get Only Balance
// This method allows you to retrieve only balance and number of transactions for a given address/wallet.
//
// API called: '/v1/btc/main/addrs/1DEP8i3QJCsom...v62aGvhD/balance'

require __DIR__ . '/../bootstrap.php';

/// override default sample address with GET parameter
if (isset($_GET['address'])) {
    $sampleAddress = filter_input(INPUT_GET, 'address', FILTER_SANITIZE_SPECIAL_CHARS);
} else {
    $sampleAddress = '1DEP8i3QJCsomS4BSMY2RpU1upv62aGvhD'; // Default address for samples
}

$addressClient = new \BlockCypher\Client\AddressClient($apiContexts['BTC.main']);

try {
    $addressBalance = $addressClient->getBalance($sampleAddress);
} catch (Exception $ex) {
    ResultPrinter::printError("Get Only Address Balance", "Address Balance", $sampleAddress, null, $ex);
    exit(1);
}

ResultPrinter::printResult("Get Only Address Balance", "Address Balance", $addressBalance->getAddress(), null, $addressBalance);

return $addressBalance;