<?php

// Run on console:
// php -f .\sample\transaction-api\TransactionHashEndpoint.php

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
$transaction = $txClient->get('f854aebae95150b379cc1187d848d58225f3c4157fe992bcd166f58bd5063449');

ResultPrinter::printResult("TX Hash Endpoint", "TX", $transaction->getHash(), null, $transaction);