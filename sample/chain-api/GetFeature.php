<?php

// # Get Blockchain Feature Status
//
// API called: '/v1/btc/main/feature/$NAME'

require __DIR__ . '/../bootstrap.php';

$blockchainClient = new \BlockCypher\Client\BlockchainClient($apiContexts['BTC.main']);

try {
    $feature = $blockchainClient->getFeature('bip65');
} catch (Exception $ex) {
    ResultPrinter::printError("Get Feature", "", "", null, $ex);
    exit(1);
}

ResultPrinter::printResult("Get Feature", "", "", null, $feature);
