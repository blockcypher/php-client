<?php

// # Create MicroTX Sample (using a builder)
//
// This sample code demonstrate how you can create a new microtransaction, as documented here at:
// <a href="http://dev.blockcypher.com/#microtransaction-endpoint">http://dev.blockcypher.com/#microtransaction-endpoint</a>
// API used: POST /v1/btc/main/txs/micro

require __DIR__ . '/../bootstrap.php';

// Create a new instance of MicroTX object
$microTX = \BlockCypher\Builder\MicroTXBuilder::aMicroTX()
    ->fromPubkey("02d4e3404e175923adf89c932fab96758716f6a0a896890f2494c5d9141eb3f543")
    ->toAddress("C4MYFr4EAdqEeUKxTnPUF3d3whWcPMz1Fi")
    ->withValueInSatoshis(10000)
    ->build();

// For Sample Purposes Only.
$request = clone $microTX;

$microTXClient = new \BlockCypher\Client\MicroTXClient($apiContexts['BCY.test']);

try {
    $output = $microTXClient->create($microTX);
} catch (Exception $ex) {
    ResultPrinter::printError("Created MicroTX", "MicroTX", null, $request, $ex);
    exit(1);
}

ResultPrinter::printResult("Created MicroTX", "MicroTX", $output->getHash(), $request, $output);

return $output;