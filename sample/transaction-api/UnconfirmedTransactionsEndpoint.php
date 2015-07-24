<?php

// Run on console:
// php -f .\sample\transaction-api\UnconfirmedTransactionsEndpoint.php

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
$txs = $txClient->getUnconfirmed(array(), $apiContext);

ResultPrinter::printResult("Get Unconfirmed Transactions", "TX[]", null, null, $txs);