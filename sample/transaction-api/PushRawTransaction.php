<?php

// # Push Raw Transaction to the Network
//
// API called: '/v1/btc/main/txs/push'

$hexRawTx = require 'CreateTransactionWithThirdPartySoftware.php';

/// For Sample Purposes Only.
$txHex = new \BlockCypher\Api\TXHex();
$txHex->setTx($hexRawTx);

try {
    /// Push Raw Transaction
    $tx = \BlockCypher\Api\TX::push($hexRawTx, array(), $apiContexts['BTC.main']);
} catch (\Exception $ex) {
    ResultPrinter::printError("Push Raw Transaction", "TX", null, $txHex, $ex);
    exit(1);
}

ResultPrinter::printResult("Push Raw Transaction", "TX", null, $txHex, $tx);