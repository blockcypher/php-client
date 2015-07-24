<?php

// Run on console:
// php -f .\sample\transaction-api\DataEndpoint.php

require __DIR__ . '/../bootstrap.php';

use BlockCypher\Auth\SimpleTokenCredential;
use BlockCypher\Client\NullDataClient;
use BlockCypher\Rest\ApiContext;

$apiContext = ApiContext::create(
    'main', 'btc', 'v1',
    new SimpleTokenCredential('c0afcccdde5081d6429de37d16166ead'),
    array('mode' => 'sandbox', 'log.LogEnabled' => true, 'log.FileName' => 'BlockCypher.log', 'log.LogLevel' => 'DEBUG')
);

$nullDataClient = new NullDataClient($apiContext);
$nullData = $nullDataClient->embedString('***BlockCypher Data Endpoint Test***'); // max 40 bytes

ResultPrinter::printResult("Embed Data On Blockchain", "NullData", $nullData->getHash(), null, $nullData);