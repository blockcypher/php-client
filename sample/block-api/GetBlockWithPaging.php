<?php

// # Get Block With Paging
// By default, we only return the 20 first transactions. This method allows you to retrieve next 20 transactions.
//
// API called: '/v1/btc/main/blocks/0000...0000c504bdea...44328?txstart=20&limit=20'

require __DIR__ . '/../bootstrap.php';

$blockClient = new \BlockCypher\Client\BlockClient();

// TX list begins at 'txstart' and we only get 'limit' transactions at once
$params = array(
    'txstart' => 1,
    'limit' => 1,
);

try {
    $block = $blockClient->get('0000000000000000c504bdea36e531d8089d324f2d936c86e3274f97f8a44328', $params, $apiContexts['BTC.main']);
} catch (Exception $ex) {
    ResultPrinter::printError("Get Block With Paging", "Block", '0000000000000000c504bdea36e531d8089d324f2d936c86e3274f97f8a44328', null, $ex);
    exit(1);
}

ResultPrinter::printResult("Get Block With Paging", "Block", $block->getHash(), null, $block);

return $block;
