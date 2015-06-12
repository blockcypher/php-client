<?php

// php -f .\sample\docs-sample\blockchain-api\chain-endpoint.php

require __DIR__ . '/../../bootstrap.php';

use BlockCypher\Api\Chain;
use BlockCypher\Auth\SimpleTokenCredential;
use BlockCypher\Rest\ApiContext;

$apiContext = ApiContext::create(
    'main', 'btc', 'v1',
    new SimpleTokenCredential('c0afcccdde5081d6429de37d16166ead')
);

$chain = Chain::get('BTC.main', array(), $apiContext);

ResultPrinter::printResult("Get Chain", "Chain", $chain->getName(), null, $chain);