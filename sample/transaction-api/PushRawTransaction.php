<?php

// # Push Raw Transaction to the Network
//
// API called: '/v1/btc/main/txs/push'

$hexRawTx = require 'CreateTransactionWithThirdPartySoftware.php';

/// For Sample Purposes Only.
$txHex = new \BlockCypher\Api\TXHex();
$txHex->setTx($hexRawTx);

$txClient = new \BlockCypher\Client\TXClient($apiContexts['BTC.main']);

try {
    /// Push Raw Transaction
    $tx = $txClient->push($hexRawTx);
} catch (\Exception $ex) {
    ResultPrinter::printError("Push Raw Transaction", "TX", null, $txHex, $ex);
    exit(1);
}

ResultPrinter::printResult("Push Raw Transaction", "TX", null, $txHex, $tx);