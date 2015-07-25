<?php

// # Create MicroTX Sample from PublicKey
// Client-side signing
//
// This sample code demonstrate how you can create a new micro transaction, as documented here at:
// <a href="http://dev.blockcypher.com/#microtransaction-endpoint">http://dev.blockcypher.com/#microtransaction-endpoint</a>
//
// API used: POST /v1/btc/main/txs/micro
//
// Addresses used in this sample:
//
// Source: <a href="https://live.blockcypher.com/bcy/address/C5vqMGme4FThKnCY44gx1PLgWr86uxRbDm/">C5vqMGme4FThKnCY44gx1PLgWr86uxRbDm</a>
//
// Destination: <a href="https://live.blockcypher.com/bcy/address/C4MYFr4EAdqEeUKxTnPUF3d3whWcPMz1Fi/">C4MYFr4EAdqEeUKxTnPUF3d3whWcPMz1Fi</a>

/// Create new microtransaction. See CreateMicroTransaction sample
/** @var \BlockCypher\Api\MicroTX $microTX */
$microTX = require 'CreateMicroTransaction.php';

// Private key must be in the same format as returned by: <a href="http://dev.blockcypher.com/#generate-address-endpoint">Generate Address Endpoint</a>
/// Address: C5vqMGme4FThKnCY44gx1PLgWr86uxRbDm
$privateKey = "2c2cc015519b79782bd9c5af66f442e808f573714e3c4dc6df7d79c183963cff";

/// Sign the MicroTX
$microTX->sign($privateKey);

/// For Sample Purposes Only.
$request = clone $microTX;

$microTXClient = new \BlockCypher\Client\MicroTXClient($apiContexts['BCY.test']);

try {
    /// Send MicroTX to the network
    $output = $microTXClient->send($microTX);
} catch (Exception $ex) {
    ResultPrinter::printError("Created MicroTX Via PublicKey", "MicroTX", null, $request, $ex);
    exit(1);
}

ResultPrinter::printResult("Created MicroTX Via PublicKey", "MicroTX", $output->getHash(), $request, $output);

return $output;