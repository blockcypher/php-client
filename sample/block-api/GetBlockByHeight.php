<?php

// # Get Block By Height
// The Block resource allows you to retrieve details about a Block.
//
// API called: '/v1/btc/main/blocks/293000'

require __DIR__ . '/../bootstrap.php';

$blockClient = new \BlockCypher\Client\BlockClient();

try {
    $block = $blockClient->get('293000', array(), $apiContexts['BTC.main']);
} catch (Exception $ex) {
    ResultPrinter::printError("Get Block By Height", "Block", '293000', null, $ex);
    exit(1);
}

ResultPrinter::printResult("Get Block By Height", "Block", $block->getHeight(), null, $block);

return $block;
