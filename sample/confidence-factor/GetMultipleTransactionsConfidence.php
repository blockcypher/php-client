<?php

// # Get Multiple Transactions Confidence Sample
// This method allows you to
// retrieve balance of multiple addresses at once.
// API called: '/v1/btc/main/txs/2b17f5...a871b;2b17f...bfa871b/confidence'

require __DIR__ . '/../bootstrap.php';

// The following code takes you through
// the process of retrieving confidence of multiple Transactions at once.

/// ### Retrieve Multiple Transactions Confidence
// (See bootstrap.php for more on `ApiContext`)
try {

    // List of transactions hashes.
    $txhashList = Array(
        '950d61ab2f51ea877e6183c8210de1677d78e16abfd4103990c3703f17de13a7',
        '6370d43593fc47daf9443e0773faf289c54ca0bd9b92c2e538c77a6db67b0780'
    );

    $txConfidence = \BlockCypher\Api\TXConfidence::getMultiple($txhashList, array(), $apiContexts['BTC.main']);
} catch (Exception $ex) {
    ResultPrinter::printError("Get Multiple Transactions Confidence", "TX Confidence", implode(",", $txhashList), null, $ex);
    exit(1);
}

ResultPrinter::printResult("Get Multiple Transactions Confidence", "TX Confidence", implode(",", $txhashList), null, $txConfidence);

return $txConfidence;