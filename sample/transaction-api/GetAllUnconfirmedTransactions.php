<?php

// # Get Unconfirmed Transactions Sample
// This method allows you to retrieve an array of the latest transactions relayed by nodes in a blockchain
// that haven’t been included in any blocks.
// API called: '/v1/btc/main/txs'

require __DIR__ . '/../bootstrap.php';

// (See bootstrap.php for more on `ApiContext`)
try {
    /// ### Retrieve Unconfirmed Transactions
    $txs = \BlockCypher\Api\TX::getUnconfirmed(array(), $apiContexts['BTC.main']);
} catch (Exception $ex) {
    ResultPrinter::printError("Get Unconfirmed Transactions", "TX[]", null, null, $ex);
    exit(1);
}

ResultPrinter::printResult("Get Unconfirmed Transactions", "TX[]", null, null, $txs);

return $txs;