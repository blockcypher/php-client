<?php

// # Get Blockchain
// The Blockchain resource allows you to retrieve details about chains.
//
// API called: '/v1/btc/main'

require __DIR__ . '/../bootstrap.php';

$blockchainClient = new \BlockCypher\Client\BlockchainClient($apiContexts['BTC.main']);

try {
    $blockchain = $blockchainClient->get('BTC.main');
} catch (Exception $ex) {
    ResultPrinter::printError("Get Blockchain", "Blockchain", 'BTC.main', null, $ex);
    exit(1);
}

ResultPrinter::printResult("Get Blockchain", "Blockchain", $blockchain->getName(), null, $blockchain);

return $blockchain;
