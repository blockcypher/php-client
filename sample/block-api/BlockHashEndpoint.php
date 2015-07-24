<?php

// Run on console:
// php -f .\sample\block-api\BlockHashEndpoint.php

require __DIR__ . '/../bootstrap.php';

use BlockCypher\Auth\SimpleTokenCredential;
use BlockCypher\Client\BlockClient;
use BlockCypher\Rest\ApiContext;

$apiContext = ApiContext::create(
    'main', 'btc', 'v1',
    new SimpleTokenCredential('c0afcccdde5081d6429de37d16166ead'),
    array('mode' => 'sandbox', 'log.LogEnabled' => true, 'log.FileName' => 'BlockCypher.log', 'log.LogLevel' => 'DEBUG')
);

$blockClient = new BlockClient($apiContext);
$block = $blockClient->get('0000000000000000189bba3564a63772107b5673c940c16f12662b3e8546b412');

ResultPrinter::printResult("Get Block", "Block", $block->getHash(), null, $block);