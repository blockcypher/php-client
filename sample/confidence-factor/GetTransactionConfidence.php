<?php

// # Get Transaction Confidence
// More info about Confidence Factor: <a href="http://dev.blockcypher.com/?php#confidence-factor">http://dev.blockcypher.com/?php#confidence-factor</a>
//
// API called: '/v1/btc/main/txs/2b17f5...a871b/confidence'

require __DIR__ . '/../bootstrap.php';

$txClient = new \BlockCypher\Client\TXClient($apiContexts['BTC.main']);

try {
    $txConfidence = $txClient->getConfidence('950d61ab2f51ea877e6183c8210de1677d78e16abfd4103990c3703f17de13a7');
} catch (Exception $ex) {
    ResultPrinter::printError("Get Only TX Confidence", "TX Confidence", '1DEP8i3QJCsomS4BSMY2RpU1upv62aGvhD', null, $ex);
    exit(1);
}

ResultPrinter::printResult("Get Only TX Confidence", "TX Confidence", $txConfidence->getTxhash(), null, $txConfidence);

return $txConfidence;