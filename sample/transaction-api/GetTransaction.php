<?php

// # Get TX Sample
// The Block resource allows you to retrieve details about a TX.
//
// API called: '/v1/btc/main/txs/f854aebae...bd5063449'

require __DIR__ . '/../bootstrap.php';

try {
    $transaction = \BlockCypher\Api\TX::get('f854aebae95150b379cc1187d848d58225f3c4157fe992bcd166f58bd5063449', array(), $apiContexts['BTC.main']);
} catch (Exception $ex) {
    ResultPrinter::printError("Get TX", "TX", 'f854aebae95150b379cc1187d848d58225f3c4157fe992bcd166f58bd5063449', null, $ex);
    exit(1);
}

ResultPrinter::printResult("Get TX", "TX", $transaction->getHash(), null, $transaction);

return $transaction;