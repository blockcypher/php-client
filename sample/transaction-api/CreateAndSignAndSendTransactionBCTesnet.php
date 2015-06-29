<?php

// # Create, Sign and Send TX Sample
//
// This sample code demonstrate how you can create a new transaction and send it to the network, as documented here at:
// <a href="http://dev.blockcypher.com/#creating-transactions">http://dev.blockcypher.com/#creating-transactions</a>
// API used: POST /v1/bcy/test/txs/new and
// POST /v1/bcy/test/txs/send

/** @var \BlockCypher\Api\TXSkeleton $txSkeleton */
$txSkeleton = require 'CreateTransactionWithTXBuilderBCTestnet.php';

// source addresses private keys
// private key in the same format as returned by Generate Address Endpoint:
// http://dev.blockcypher.com/?shell#generate-address-endpoint
$privateKeys = array(
    "2c2cc015519b79782bd9c5af66f442e808f573714e3c4dc6df7d79c183963cff" // Address: C5vqMGme4FThKnCY44gx1PLgWr86uxRbDm
);

// ### Sign the TX
try {
    $txSkeleton->sign($privateKeys, $apiContexts['BCY.test']);
} catch (Exception $ex) {
    ResultPrinter::printError("Sign Transaction DOGE", "TXSkeleton", null, $request, $ex);
    exit(1);
}
// Source and Destination addresses used in this sample
// https://live.blockcypher.com/bcy/address/C5vqMGme4FThKnCY44gx1PLgWr86uxRbDm/
// https://live.blockcypher.com/bcy/address/C4MYFr4EAdqEeUKxTnPUF3d3whWcPMz1Fi/

// For sample purposes only.
$request = clone $txSkeleton;

try {
    // ### Send TX to the network
    $txSkeleton = $txSkeleton->send($apiContexts['BCY.test']);
} catch (Exception $ex) {
    ResultPrinter::printError("Send Transaction DOGE", "TXSkeleton", null, $request, $ex);
    exit(1);
}

ResultPrinter::printResult("Send Transaction DOGE", "TXSkeleton", $txSkeleton->getTx()->getHash(), $request, $txSkeleton);

return $output;