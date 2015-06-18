<?php

// # Get Blockchain Sample
// The Blockchain resource allows you to
// retrieve details about chains.
// API called: '/v1/btc/main'

require __DIR__ . '/../bootstrap.php';

// The following code takes you through
// the process of retrieving details about a chain

/// ### Retrieve Blockchain
// (See bootstrap.php for more on `ApiContext`)
try {
    $blockchain = \BlockCypher\Api\Blockchain::get('BTC.main', array(), $apiContexts['BTC.main']);
} catch (Exception $ex) {
    ResultPrinter::printError("Get Blockchain", "Blockchain", 'BTC.main', null, $ex);
    exit(1);
}

ResultPrinter::printResult("Get Blockchain", "Blockchain", $blockchain->getName(), null, $blockchain);

return $blockchain;
