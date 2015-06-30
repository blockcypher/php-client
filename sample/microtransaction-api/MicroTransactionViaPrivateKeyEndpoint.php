<?php

// Run on console:
// php -f .\sample\microtransaction-api\MicroTransactionViaPrivateKeyEndpoint.php

require __DIR__ . '/../bootstrap.php';

use BlockCypher\Api\MicroTX;
use BlockCypher\Auth\SimpleTokenCredential;
use BlockCypher\Rest\ApiContext;

$apiContext = ApiContext::create(
    'test', 'bcy', 'v1',
    new SimpleTokenCredential('c0afcccdde5081d6429de37d16166ead'),
    array('mode' => 'sandbox', 'log.LogEnabled' => true, 'log.FileName' => 'BlockCypher.log', 'log.LogLevel' => 'DEBUG')
);

$microTX = new MicroTX();
$microTX->setFromPrivate("2c2cc015519b79782bd9c5af66f442e808f573714e3c4dc6df7d79c183963cff");
$microTX->setToAddress("C4MYFr4EAdqEeUKxTnPUF3d3whWcPMz1Fi");
$microTX->setValueSatoshis(10000);

// For Sample Purposes Only.
$request = clone $microTX;

$microTX->create($apiContext);

ResultPrinter::printResult("Created MicroTX Via PrivateKey Endpoint", "MicroTX", $microTX->getHash(), $request, $microTX);