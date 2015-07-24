<?php

// Run on console:
// php -f .\sample\introduction\Batching.php
// Batching blocks 5, 6, and 7

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
$blockList = array('5', '6', '7');
$blocks = $blockClient->getMultiple($blockList);

ResultPrinter::printResult("Batching", "Block[]", implode(",", $blockList), null, $blocks);