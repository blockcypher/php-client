<?php

// php -f .\sample\docs-sample\blockchain-api\block-hash-endpoint.php

require __DIR__ . '/../../bootstrap.php';

use BlockCypher\Api\Block;
use BlockCypher\Auth\SimpleTokenCredential;
use BlockCypher\Rest\ApiContext;

$apiContext = ApiContext::create(
    'main', 'btc', 'v1',
    new SimpleTokenCredential('c0afcccdde5081d6429de37d16166ead')
);

$block = Block::get('0000000000000000c504bdea36e531d8089d324f2d936c86e3274f97f8a44328', array(), $apiContext);

ResultPrinter::printResult("Get Block", "Block", $block->getHash(), null, $block);