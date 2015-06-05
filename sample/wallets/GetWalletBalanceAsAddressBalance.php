<?php

// # Get Only Wallet Balance Sample
// This method allows you to
// retrieve only balance and number of transactions for a given wallet.
// API called: '/v1/btc/main/addrs/alice/balance'

require __DIR__ . '/../bootstrap.php';

// The following code takes you through
// the process of retrieving balance about this wallet 'alice'

// Wallet must be created
if (isset($_GET['wallet_name'])) {
    $walletName = filter_input(INPUT_GET, 'wallet_name', FILTER_SANITIZE_SPECIAL_CHARS);
} else {
    $walletName = 'alice'; // Default wallet name for samples
}

/// ### Retrieve this wallet 'alice'
// (See bootstrap.php for more on `ApiContext`)
try {
    $addressBalance = \BlockCypher\Api\Address::getOnlyBalance($walletName, array(), $apiContexts['BTC.main']);
} catch (Exception $ex) {
    ResultPrinter::printError("Get Only Address Balance", "Wallet Balance", $walletName, null, $ex);
    exit(1);
}

ResultPrinter::printResult("Get Only Address Balance", "Wallet Balance", $addressBalance->getAddress(), null, $addressBalance);

return $addressBalance;