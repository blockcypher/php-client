<?php

// # Get Block Sample
// The Block resource allows you to
// retrieve details about a Block.
// API called: '/v1/btc/main/blocks/293000'

require __DIR__ . '/../bootstrap.php';

// The following code takes you through
// the process of retrieving details about a Block.

/// ### Retrieve Block by height
// (See bootstrap.php for more on `ApiContext`)
try {
    $block = \BlockCypher\Api\Block::get('293000', array(), $apiContext);
} catch (Exception $ex) {
    ResultPrinter::printError("Get Block By Height", "Block", '293000', null, $ex);
    exit(1);
}

ResultPrinter::printResult("Get Block By Height", "Block", $block->getHeight(), null, $block);

return $block;
