<?php

// Run on console:
// php -f .\sample\confidence-factor\TransactionConfidenceEndpoint.php

require __DIR__ . '/../bootstrap.php';

use BlockCypher\Auth\SimpleTokenCredential;
use BlockCypher\Client\TXClient;
use BlockCypher\Rest\ApiContext;

$apiContext = ApiContext::create(
    'main', 'btc', 'v1',
    new SimpleTokenCredential('c0afcccdde5081d6429de37d16166ead'),
    array('mode' => 'sandbox', 'log.LogEnabled' => true, 'log.FileName' => 'BlockCypher.log', 'log.LogLevel' => 'DEBUG')
);

$txClient = new TXClient($apiContext);
$txConfidence = $txClient->getConfidence('43fa951e1bea87c282f6725cf8bdc08bb48761396c3af8dd5a41a085ab62acc9');

ResultPrinter::printResult("TX Confidence Endpoint", "TXConfidence", $txConfidence->getTxhash(), null, $txConfidence);

return $txConfidence;