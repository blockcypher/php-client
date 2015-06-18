<?php

// # Get TX Confidence Sample
// This method allows you to
// retrieve only balance and number of transactions for a given address/wallet.
// API called: '/v1/btc/main/txs/2b17f5...a871b'

require __DIR__ . '/../bootstrap.php';

// The following code takes you through
// the process of retrieving confidence about this transaction 950d61ab2f51ea877e6183c8210de1677d78e16abfd4103990c3703f17de13a7

/// ### Retrieve this transaction 950d61ab2f51ea877e6183c8210de1677d78e16abfd4103990c3703f17de13a7 confidence
// (See bootstrap.php for more on `ApiContext`)
try {
    $txConfidence = \BlockCypher\Api\TXConfidence::get('950d61ab2f51ea877e6183c8210de1677d78e16abfd4103990c3703f17de13a7', array(), $apiContexts['BTC.main']);
} catch (Exception $ex) {
    ResultPrinter::printError("Get Only TX Confidence", "TX Confidence", '1DEP8i3QJCsomS4BSMY2RpU1upv62aGvhD', null, $ex);
    exit(1);
}

ResultPrinter::printResult("Get Only TX Confidence", "TX Confidence", $txConfidence->getTxhash(), null, $txConfidence);

return $txConfidence;