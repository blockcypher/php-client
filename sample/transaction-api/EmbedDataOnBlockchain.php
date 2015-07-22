<?php

// # Embed Data on Blockchains
// The NullData resource allows you to embed data on a Blockchain.
//
// API called: '/v1/btc/main/txs/data'

require __DIR__ . '/../bootstrap.php';

$data = '***BlockCypher Data Endpoint Test***'; // max 40 bytes

/// For Sample Purposes Only.
$nullData = new \BlockCypher\Api\NullData();
$nullData->setEncoding('string');
$nullData->setData($data); // max 40 bytes
$request = clone $nullData;

$nullDataClient = new \BlockCypher\Client\NullDataClient($apiContexts['BTC.main']);

try {
    /// Create TX with embed data
    $nullData = $nullDataClient->embedString($data); // max 40 bytes
} catch (Exception $ex) {
    ResultPrinter::printError("Embed Data On Blockchain", "NullData", null, $request, $ex);
    exit(1);
}

ResultPrinter::printResult("Embed Data On Blockchain", "NullData", $nullData->getHash(), $request, $nullData);

return $nullData;