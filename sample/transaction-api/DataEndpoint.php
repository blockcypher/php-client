<?php

// Run on console:
// php -f .\sample\transaction-api\DataEndpoint.php

require __DIR__ . '/../bootstrap.php';

use BlockCypher\Api\NullData;
use BlockCypher\Auth\SimpleTokenCredential;
use BlockCypher\Rest\ApiContext;

$apiContext = ApiContext::create(
    'main', 'btc', 'v1',
    new SimpleTokenCredential('c0afcccdde5081d6429de37d16166ead'),
    array('log.LogEnabled' => true, 'log.FileName' => 'BlockCypher.log', 'log.LogLevel' => 'DEBUG')
);

$nullData = new NullData();
$nullData->setEncoding('string');
$nullData->setData('***BlockCypher Data Endpoint Test***'); // max 40 bytes

// For Sample Purposes Only.
$request = clone $nullData;

$nullData->create(array(), $apiContext);

ResultPrinter::printResult("Embed Data On Blockchain", "NullData", $nullData->getHash(), $request, $nullData);