<?php

// # Get Multiple Transactions Confidence
// More info about Confidence Factor: <a href="http://dev.blockcypher.com/?php#confidence-factor">http://dev.blockcypher.com/?php#confidence-factor</a>
//
// API called: '/v1/btc/main/txs/2b17f5...a871b;2b17f...bfa871b/confidence'

require __DIR__ . '/../bootstrap.php';

$txClient = new \BlockCypher\Client\TXClient($apiContexts['BTC.main']);

try {
    /// Transaction hash list
    $txhashList = array(
        '950d61ab2f51ea877e6183c8210de1677d78e16abfd4103990c3703f17de13a7',
        '6370d43593fc47daf9443e0773faf289c54ca0bd9b92c2e538c77a6db67b0780'
    );
    $txConfidences = $txClient->getMultipleConfidences($txhashList);
} catch (Exception $ex) {
    ResultPrinter::printError("Get Multiple Transaction Confidence", "TX Confidence", implode(",", $txhashList), null, $ex);
    exit(1);
}

ResultPrinter::printResult("Get Multiple Transaction Confidence", "TX Confidence", implode(",", $txhashList), null, $txConfidences);

return $txConfidences;