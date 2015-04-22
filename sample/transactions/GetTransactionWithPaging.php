<?php

// # Get Transaction With Paging Sample
// Inputs and outputs are limited to 20. Use paging to get more.
// API called: '/v1/btc/main/txs/f854aebae95150b379cc1187d848d58225f3c4157fe992bcd166f58bd5063449'

require __DIR__ . '/../bootstrap.php';

// The following code takes you through
// the process of retrieving more inputs and outputs from a Transaction when they exceeds 20

/// ### Retrieve Transaction
// (See bootstrap.php for more on `ApiContext`)
try {
    $params = array(
        'instart' => 1,
        'outstart' => 1,
        'limit' => 1,
    );
    $transaction = \BlockCypher\Api\Transaction::get('f854aebae95150b379cc1187d848d58225f3c4157fe992bcd166f58bd5063449', $params, $apiContext);
} catch (Exception $ex) {
    ResultPrinter::printError("Get Transaction Paging Inputs and Outputs", "Transaction", 'f854aebae95150b379cc1187d848d58225f3c4157fe992bcd166f58bd5063449', null, $ex);
    exit(1);
}

ResultPrinter::printResult("Get Transaction Paging Inputs and Outputs", "Transaction", $transaction->getHash(), null, $transaction);

return $transaction;