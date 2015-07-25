<?php

// Run on console:
// php -f .\sample\microtransaction-api\CreateMicroTXFromPubkeyDocsSample.php

require __DIR__ . '/../bootstrap.php';

use BlockCypher\Auth\SimpleTokenCredential;
use BlockCypher\Client\MicroTXClient;
use BlockCypher\Rest\ApiContext;

$apiContext = ApiContext::create(
    'test', 'bcy', 'v1',
    new SimpleTokenCredential('c0afcccdde5081d6429de37d16166ead'),
    array('mode' => 'sandbox', 'log.LogEnabled' => true, 'log.FileName' => 'BlockCypher.log', 'log.LogLevel' => 'DEBUG')
);

$microTXClient = new MicroTXClient($apiContext);
$microTX = $microTXClient->sendSigned(
    "2c2cc015519b79782bd9c5af66f442e808f573714e3c4dc6df7d79c183963cff", // private key
    "C4MYFr4EAdqEeUKxTnPUF3d3whWcPMz1Fi", // to address
    10000 // value (satoshis)
);

ResultPrinter::printResult("Created, Sign and Send MicroTX", "MicroTX", $microTX->getHash(), null, $microTX);