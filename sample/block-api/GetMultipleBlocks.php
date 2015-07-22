<?php

// # Get Multiple Blocks
// This method allows you to retrieve details about multiple blocks at once.
//
// API called: '/v1/btc/main/blocks/5;6;7'
//
// You can use height or hash and mix them in the same $blockList

require __DIR__ . '/../bootstrap.php';

$blockClient = new \BlockCypher\Client\BlockClient();
$blockList = array('5', '6', '7');

try {
    $blocks = $blockClient->getMultiple($blockList, array(), $apiContexts['BTC.main']);
} catch (Exception $ex) {
    ResultPrinter::printError("Get Multiple Blocks", "Blocks", implode(",", $blockList), null, $ex);
    exit(1);
}

ResultPrinter::printResult("Get Multiple Blocks", "Blocks", implode(",", $blockList), null, $blocks);

return $blocks;