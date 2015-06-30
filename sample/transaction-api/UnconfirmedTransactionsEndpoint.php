<?php

// Run on console:
// php -f .\sample\transaction-api\UnconfirmedTransactionsEndpoint.php

require __DIR__ . '/../bootstrap.php';

use BlockCypher\Api\TX;
use BlockCypher\Auth\SimpleTokenCredential;
use BlockCypher\Rest\ApiContext;

$apiContext = ApiContext::create(
    'main', 'btc', 'v1',
    new SimpleTokenCredential('c0afcccdde5081d6429de37d16166ead'),
    array('mode' => 'sandbox', 'log.LogEnabled' => true, 'log.FileName' => 'BlockCypher.log', 'log.LogLevel' => 'DEBUG')
);

$txs = TX::getUnconfirmed(array(), $apiContext);

ResultPrinter::printResult("Get Unconfirmed Transactions", "TX[]", null, null, $txs);