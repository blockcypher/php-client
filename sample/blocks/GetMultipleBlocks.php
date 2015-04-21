<?php

// # Get Block Sample
// The Block resource allows you to
// retrieve details about multiple blocks at once.
// API called: '/v1/btc/main/blocks/5;6;7'

require __DIR__ . '/../bootstrap.php';

// The following code takes you through
// the process of retrieving details about multiple Blocks at once.

/// ### Retrieve Blocks by height
// (See bootstrap.php for more on `ApiContext`)
try {

    // ### List of blocks. You can use height or hash and mix them in the same request
    $blockList = Array('5', '6', '7');

    $blocks = \BlockCypher\Api\Block::getMultiple($blockList, $apiContext);
} catch (Exception $ex) {
    ResultPrinter::printError("Get Multiple Blocks", "Blocks", implode(",", $blockList), null, $ex);
    exit(1);
}

ResultPrinter::printResult("Get Multiple Blocks", "Blocks", implode(",", $blockList), null, $blocks);

return $blocks;