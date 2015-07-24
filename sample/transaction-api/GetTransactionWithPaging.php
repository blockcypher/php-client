<?php

// # Get Transactions With Paging
// Inputs and outputs are limited to 20. Use paging to get more.
//
// API called: '/v1/btc/main/txs/f854aebae9515...f58bd5063449'

require __DIR__ . '/../bootstrap.php';

$txClient = new \BlockCypher\Client\TXClient($apiContexts['BTC.main']);

try {
    $params = array(
        'instart' => 1,
        'outstart' => 1,
        'limit' => 1,
    );
    $transaction = $txClient->get('f854aebae95150b379cc1187d848d58225f3c4157fe992bcd166f58bd5063449', $params);
} catch (Exception $ex) {
    ResultPrinter::printError("Get TX Paging Inputs and Outputs", "TX", 'f854aebae95150b379cc1187d848d58225f3c4157fe992bcd166f58bd5063449', null, $ex);
    exit(1);
}

ResultPrinter::printResult("Get TX Paging Inputs and Outputs", "TX", $transaction->getHash(), null, $transaction);

return $transaction;