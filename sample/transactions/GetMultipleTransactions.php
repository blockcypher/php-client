<?php

// # Get Multiple Transactions Sample
// This method allows you to
// retrieve details about multiple transactions at once.
// API called: '/v1/btc/main/txs/950d61a...7de13a7;6370d4359...67b0780'

require __DIR__ . '/../bootstrap.php';

// The following code takes you through
// the process of retrieving details about multiple Transactions at once.

/// ### Retrieve Multiple Transactions
// (See bootstrap.php for more on `ApiContext`)
try {

    // List of transactions. You can use height or hash and mix them in the same request
    $transactionList = Array(
        '950d61ab2f51ea877e6183c8210de1677d78e16abfd4103990c3703f17de13a7',
        '6370d43593fc47daf9443e0773faf289c54ca0bd9b92c2e538c77a6db67b0780'
    );

    $transactions = \BlockCypher\Api\Transaction::getMultiple($transactionList, array(), $apiContext);
} catch (Exception $ex) {
    ResultPrinter::printError("Get Multiple Transactions", "Transactions", implode(",", $transactionList), null, $ex);
    exit(1);
}

ResultPrinter::printResult("Get Multiple Transactions", "Transactions", implode(",", $transactionList), null, $transactions);

return $transactions;