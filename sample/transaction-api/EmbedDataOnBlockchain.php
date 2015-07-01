<?php

// # Embed Data on Blockchains
// The NullData resource allows you to embed data on a Blockchain.
//
// API called: '/v1/btc/main/txs/data'

require __DIR__ . '/../bootstrap.php';

$nullData = new \BlockCypher\Api\NullData();
$nullData->setEncoding('string');
$nullData->setData('***BlockCypher Data Endpoint Test***'); // max 40 bytes

/// For Sample Purposes Only.
$request = clone $nullData;

try {
    /// Create TX with embed data
    $nullData->create(array(), $apiContexts['BTC.main']);
} catch (Exception $ex) {
    ResultPrinter::printError("Embed Data On Blockchain", "NullData", null, $request, $ex);
    exit(1);
}

ResultPrinter::printResult("Embed Data On Blockchain", "NullData", $nullData->getHash(), $request, $nullData);

return $nullData;