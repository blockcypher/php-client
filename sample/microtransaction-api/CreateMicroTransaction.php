<?php

// # Create MicroTX Sample
//
// This sample code demonstrate how you can create a new microtransaction, as documented here at:
// <a href="http://dev.blockcypher.com/#microtransaction-endpoint">http://dev.blockcypher.com/#microtransaction-endpoint</a>
// API used: POST /v1/btc/main/txs/micro

require __DIR__ . '/../bootstrap.php';

// Create a new instance of MicroTX object
$microTX = new \BlockCypher\Api\MicroTX();
// Source address: https://live.blockcypher.com/bcy/address/C5vqMGme4FThKnCY44gx1PLgWr86uxRbDm/
$microTX->setFromPubkey("02d4e3404e175923adf89c932fab96758716f6a0a896890f2494c5d9141eb3f543");
// Destination address: https://live.blockcypher.com/bcy/address/C4MYFr4EAdqEeUKxTnPUF3d3whWcPMz1Fi/
$microTX->setToAddress("C4MYFr4EAdqEeUKxTnPUF3d3whWcPMz1Fi");
$microTX->setValueSatoshis(10000);

// For Sample Purposes Only.
$request = clone $microTX;

try {
    // ### Create New MicroTX
    $output = $microTX->create($apiContexts['BCY.test']);
} catch (Exception $ex) {
    ResultPrinter::printError("Created MicroTX", "MicroTX", null, $request, $ex);
    exit(1);
}

ResultPrinter::printResult("Created MicroTX", "MicroTX", $output->getHash(), $request, $output);

return $output;