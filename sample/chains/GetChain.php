<?php

// # Get Chain Sample
// The Chain resource allows you to
// retrieve details about chains.
// API called: '/v1/btc/main'

require __DIR__ . '/../bootstrap.php';

// The following code takes you through
// the process of retrieving details about a chain

/// ### Retrieve Chain
// (See bootstrap.php for more on `ApiContext`)
try {
    $chain = \BlockCypher\Api\Chain::get('BTC.main', array(), $apiContext);
} catch (Exception $ex) {
    ResultPrinter::printError("Get Chain", "Chain", 'BTC.main', null, $ex);
    exit(1);
}

ResultPrinter::printResult("Get Chain", "Chain", $chain->getName(), null, $chain);

return $chain;
