<?php

// # Get Unconfirmed Transactions
// This method allows you to retrieve an array of the latest transactions relayed by nodes in a blockchain
// that haven’t been included in any blocks.
//
// API called: '/v1/btc/main/txs'

require __DIR__ . '/../bootstrap.php';

$txClient = new \BlockCypher\Client\TXClient($apiContexts['BTC.main']);

try {
    $txs = $txClient->getUnconfirmed();
} catch (Exception $ex) {
    ResultPrinter::printError("Get Unconfirmed Transactions", "TX[]", null, null, $ex);
    exit(1);
}

ResultPrinter::printResult("Get Unconfirmed Transactions", "TX[]", null, null, $txs);

return $txs;