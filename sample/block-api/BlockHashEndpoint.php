<?php

// Run on console:
// php -f .\sample\block-api\BlockHashEndpoint.php

require __DIR__ . '/../bootstrap.php';

use BlockCypher\Api\Block;
use BlockCypher\Auth\SimpleTokenCredential;
use BlockCypher\Rest\ApiContext;

$apiContext = ApiContext::create(
    'main', 'btc', 'v1',
    new SimpleTokenCredential('c0afcccdde5081d6429de37d16166ead'),
    array('log.LogEnabled' => true, 'log.FileName' => 'BlockCypher.log', 'log.LogLevel' => 'DEBUG')
);

$block = Block::get('0000000000000000189bba3564a63772107b5673c940c16f12662b3e8546b412', array(), $apiContext);

ResultPrinter::printResult("Get Block", "Block", $block->getHash(), null, $block);