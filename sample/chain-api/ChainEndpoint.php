<?php

// Run on console:
// php -f .\sample\chain-api\ChainEndpoint.php

require __DIR__ . '/../bootstrap.php';

use BlockCypher\Api\Blockchain;
use BlockCypher\Auth\SimpleTokenCredential;
use BlockCypher\Rest\ApiContext;

$apiContext = ApiContext::create(
    'main', 'btc', 'v1',
    new SimpleTokenCredential('c0afcccdde5081d6429de37d16166ead'),
    array('log.LogEnabled' => true, 'log.FileName' => 'BlockCypher.log', 'log.LogLevel' => 'DEBUG')
);

$blockchain = Blockchain::get('BTC.main', array(), $apiContext);

ResultPrinter::printResult("Get Blockchain", "Blockchain", $blockchain->getName(), null, $blockchain);