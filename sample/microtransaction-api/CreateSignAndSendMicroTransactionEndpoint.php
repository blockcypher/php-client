<?php

// Run on console:
// php -f .\sample\microtransaction-api\CreateSignAndSendMicrotransactionEndpoint.php

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
$microTX->setFromPubkey("02d4e3404e175923adf89c932fab96758716f6a0a896890f2494c5d9141eb3f543")
    ->setToAddress("C4MYFr4EAdqEeUKxTnPUF3d3whWcPMz1Fi")
    ->setValueSatoshis(10000)
    ->create($apiContext)
    ->sign("2c2cc015519b79782bd9c5af66f442e808f573714e3c4dc6df7d79c183963cff")
    ->send($apiContext);

ResultPrinter::printResult("Created, Sign and Send MicroTX", "MicroTX", $microTX->getHash(), null, $microTX);