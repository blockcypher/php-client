<?php

// php -f .\sample\docs-sample\introduction\batching.php

require __DIR__ . '/../../bootstrap.php';

use BlockCypher\Auth\SimpleTokenCredential;
use BlockCypher\Rest\ApiContext;

$apiContext = ApiContext::create(
    'main', 'btc', 'v1',
    new SimpleTokenCredential('c0afcccdde5081d6429de37d16166ead')
);

$blockList = array('5', '6', '7');
//$blockList = explode(";", "5;6;7");
//$blockList = [5,6,7]; // PHP 5.4

$blocks = \BlockCypher\Api\Block::getMultiple($blockList, array(), $apiContexts['BTC.main']);

ResultPrinter::printResult("Get Multiple Blocks", "Blocks", '5, 6, 7', null, $blocks);