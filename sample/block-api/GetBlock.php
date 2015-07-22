<?php

// # Get Block
// The Block resource allows you to retrieve details about a Block.
//
// API called: '/v1/btc/main/blocks/0000000000000...f97f8a44328'

require __DIR__ . '/../bootstrap.php';

$blockClient = new \BlockCypher\Client\BlockClient($apiContexts['BTC.main']);

try {
    $block = $blockClient->get('0000000000000000c504bdea36e531d8089d324f2d936c86e3274f97f8a44328');
} catch (Exception $ex) {
    ResultPrinter::printError("Get Block", "Block", '0000000000000000c504bdea36e531d8089d324f2d936c86e3274f97f8a44328', null, $ex);
    exit(1);
}

ResultPrinter::printResult("Get Block", "Block", $block->getHash(), null, $block);

return $block;
