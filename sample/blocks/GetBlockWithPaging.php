<?php

// # Get Block With Paging Sample
// By default, we only return the 20 first transactions.
// This method allows you to
// retrieve next 20 transactions.
// API called: '/v1/btc/main/blocks/0000...0000c504bdea...44328?txstart=20&limit=20'

require __DIR__ . '/../bootstrap.php';

// The following code takes you through
// the process of retrieving details about a Block.
// Transaction list begins at 'txstart' and we only get 'limit' transactions at once

/// ### Retrieve Block by hash with only one transaction starting at transaction 1 (the second)
// (See bootstrap.php for more on `ApiContext`)
try {
    $params = array(
        'txstart' => 1,
        'limit' => 1,
    );
    $block = \BlockCypher\Api\Block::get('0000000000000000c504bdea36e531d8089d324f2d936c86e3274f97f8a44328', $params, $apiContext);
} catch (Exception $ex) {
    ResultPrinter::printError("Get Block With Paging", "Block", '0000000000000000c504bdea36e531d8089d324f2d936c86e3274f97f8a44328', null, $ex);
    exit(1);
}

ResultPrinter::printResult("Get Block With Paging", "Block", $block->getHash(), null, $block);

return $block;
