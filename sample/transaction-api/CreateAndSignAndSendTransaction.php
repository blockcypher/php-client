<?php

// # Create, Sign and Send Transaction
//
// This sample code demonstrate how you can sign a transaction and send it to the network, as documented here at:
// <a href="http://dev.blockcypher.com/#creating-transactions">http://dev.blockcypher.com/#creating-transactions</a>
//
// API used:
// POST /v1/btc/main/txs/new and
// POST /v1/btc/main/txs/send

// Addresses used in this sample:
//
// Source:
// <a href="https://live.blockcypher.com/btc-testnet/address/n3D2YXwvpoPg8FhcWpzJiS3SvKKGD8AXZ4/">n3D2YXwvpoPg8FhcWpzJiS3SvKKGD8AXZ4</a>
// Destination:
// <a href="https://live.blockcypher.com/btc-testnet/address/mvwhcFDFjmbDWCwVJ73b8DcG6bso3CZXDj/">mvwhcFDFjmbDWCwVJ73b8DcG6bso3CZXDj</a>

// Tx is created in sample CreateTransaction
/** @var \BlockCypher\Api\TXSkeleton $txSkeleton */
$txSkeleton = require 'CreateTransaction.php';

$txClient = new \BlockCypher\Client\TXClient($apiContexts['BTC.test3']);

// Private key must have the same format as returned by Generate Address Endpoint:
// <a href="http://dev.blockcypher.com/?#generate-address-endpoint">http://dev.blockcypher.com/?#generate-address-endpoint</a>
$privateKeys = array(
    "1551558c3b75f46b71ec068f9e341bf35ee6df361f7b805deb487d8a4d5f055e" // Address: n3D2YXwvpoPg8FhcWpzJiS3SvKKGD8AXZ4
);

/// Sign TXSkeleton
$txSkeleton = $txClient->sign($txSkeleton, $privateKeys);

/// For sample purposes only.
$request = clone $txSkeleton;

try {
    /// Send TX to the network
    $txSkeleton = $txClient->send($txSkeleton);
} catch (Exception $ex) {
    ResultPrinter::printError("Send Transaction", "TXSkeleton", null, $request, $ex);
    exit(1);
}

ResultPrinter::printResult("Send Transaction", "TXSkeleton", $txSkeleton->getTx()->getHash(), $request, $txSkeleton);