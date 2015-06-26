<?php

// # Create, Sign and Send TX Sample
//
// This sample code demonstrate how you can create a new transaction and send it to the network, as documented here at:
// <a href="http://dev.blockcypher.com/#creating-transactions">http://dev.blockcypher.com/#creating-transactions</a>
// API used: POST /v1/btc/main/txs/new and
// POST /v1/btc/main/txs/send

/** @var \BlockCypher\Api\TXSkeleton $txSkeleton */
$txSkeleton = require 'CreateTransaction.php';

// source addresses private keys
// private key in the same format as returned by Generate Address Endpoint:
// http://dev.blockcypher.com/?shell#generate-address-endpoint
$privateKeys = array(
    "1551558c3b75f46b71ec068f9e341bf35ee6df361f7b805deb487d8a4d5f055e" // Address: n3D2YXwvpoPg8FhcWpzJiS3SvKKGD8AXZ4
);

// ### Sign the TX
$txSkeleton->sign($privateKeys, $apiContexts['BTC.test3']);

// Source and Destination addresses used in this sample
// https://live.blockcypher.com/btc-testnet/address/n3D2YXwvpoPg8FhcWpzJiS3SvKKGD8AXZ4/
// https://live.blockcypher.com/btc-testnet/address/mvwhcFDFjmbDWCwVJ73b8DcG6bso3CZXDj/

// For sample purposes only.
$request = clone $txSkeleton;

try {
    // ### Send TX to the network
    $txSkeleton = $txSkeleton->send($apiContexts['BTC.test3']);
} catch (Exception $ex) {
    ResultPrinter::printError("Send Transaction", "TXSkeleton", null, $request, $ex);
    exit(1);
}

ResultPrinter::printResult("Send Transaction", "TXSkeleton", $txSkeleton->getTx()->getHash(), $request, $txSkeleton);

return $output;