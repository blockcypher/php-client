<?php

// Docs site sample
// php -f .\sample\blockchain-api\BlockHeightEndpoint.php

require __DIR__ . '/../bootstrap.php';

use BlockCypher\Auth\SimpleTokenCredential;
use BlockCypher\Rest\ApiContext;

$apiContext = ApiContext::create(
    'main', 'btc', 'v1',
    new SimpleTokenCredential('c0afcccdde5081d6429de37d16166ead')
);

$params = array(
    'txstart' => 1,
    'limit' => 1,
);

$block = \BlockCypher\Api\Block::get('293000', $params, $apiContext);

ResultPrinter::printResult("Get Block With Paging", "Block", $block->getHash(), null, $block);