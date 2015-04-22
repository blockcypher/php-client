<?php

// # Get Transaction Sample
// The Block resource allows you to
// retrieve details about a Transaction.
// API called: '/v1/btc/main/txs/f854aebae95150b379cc1187d848d58225f3c4157fe992bcd166f58bd5063449'

require __DIR__ . '/../bootstrap.php';

// The following code takes you through
// the process of retrieving a Transaction

/// ### Retrieve Transaction
// (See bootstrap.php for more on `ApiContext`)
try {
    $transaction = \BlockCypher\Api\Transaction::get('f854aebae95150b379cc1187d848d58225f3c4157fe992bcd166f58bd5063449', array(), $apiContext);
} catch (Exception $ex) {
    ResultPrinter::printError("Get Transaction", "Transaction", 'f854aebae95150b379cc1187d848d58225f3c4157fe992bcd166f58bd5063449', null, $ex);
    exit(1);
}

ResultPrinter::printResult("Get Transaction", "Transaction", $transaction->getHash(), null, $transaction);

return $transaction;