<?php

// # Create MicroTX
// Sending private key to the server (server-side signing).
//
// This sample code demonstrate how you can create a new micro transaction, as documented here at:
// <a href="http://dev.blockcypher.com/#microtransaction-endpoint">http://dev.blockcypher.com/#microtransaction-endpoint</a>
//
// API used: POST /v1/btc/main/txs/micro

require __DIR__ . '/../bootstrap.php';

// Addresses used in this sample:
//
// Source : <a href="https://live.blockcypher.com/bcy/address/C5vqMGme4FThKnCY44gx1PLgWr86uxRbDm/">C5vqMGme4FThKnCY44gx1PLgWr86uxRbDm</a>
//
// Destination: <a href="https://live.blockcypher.com/bcy/address/C4MYFr4EAdqEeUKxTnPUF3d3whWcPMz1Fi/">C4MYFr4EAdqEeUKxTnPUF3d3whWcPMz1Fi</a>

$microTX = new \BlockCypher\Api\MicroTX();
$microTX->setFromPrivate("2c2cc015519b79782bd9c5af66f442e808f573714e3c4dc6df7d79c183963cff");
$microTX->setToAddress("C4MYFr4EAdqEeUKxTnPUF3d3whWcPMz1Fi");
$microTX->setValueSatoshis(10000);

/// For Sample Purposes Only.
$request = clone $microTX;

$microTXClient = new \BlockCypher\Client\MicroTXClient($apiContexts['BCY.test']);

try {
    $output = $microTXClient->create($microTX);
} catch (Exception $ex) {
    ResultPrinter::printError("Created MicroTX Via PrivateKey", "MicroTX", null, $request, $ex);
    exit(1);
}

ResultPrinter::printResult("Created MicroTX Via PrivateKey", "MicroTX", $output->getHash(), $request, $output);

return $output;