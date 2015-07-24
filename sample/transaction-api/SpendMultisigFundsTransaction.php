<?php

// # Spend Multisig Funds Sample
//
// This sample code demonstrate how you can create a new transaction and send it to the network
// to spend fund from multisig address, as documented at <a href="http://dev.blockcypher.com/#multisig-transactions">docs</a>.
//
// API used: POST /v1/btc/main/txs/new and
//
// POST /v1/btc/main/txs/send

/** @var \BlockCypher\Api\TXSkeleton $txSkeleton */
$txSkeleton = require 'CreateTransactionToSpendMultisigFunds.php';

// Private keys (at least 2 of 3) in the same format as returned by <a href="http://dev.blockcypher.com/#generate-address-endpoint">Generate Address Endpoint</a>.
$privateKeys = array(
    "bb5b3be6d9ac87a16660f363e3597861f06bb8bdf3de2c46e957f922dda37f68",
    "e394e5ee8e28d4454a7d328eea58a369cdd63ec6d471ac89ca1cb8a80b72a6eb"
    //"5399dfcf4e8a3f2be7a04ca2a92b69a88576b85b7c0f7a14d773e5682c5a8613"
);

/// For sample purposes only.
$request = clone $txSkeleton;

$txClient = new \BlockCypher\Client\TXClient($apiContexts['BTC.test3']);

/// Sign the TX
try {
    $txSkeleton = $txClient->sign($txSkeleton, $privateKeys);
} catch (Exception $ex) {
    ResultPrinter::printError("Sign Transaction (spend multisig funds)", "TXSkeleton", null, $request, $ex);
    exit(1);
}

// Source (multisig) address: <a href="https://live.blockcypher.com/btc-testnet/address/2Mu7dJvawNdhshTkKRXGAVLKdr2VA7Rs1wZ/">2Mu7dJvawNdhshTkKRXGAVLKdr2VA7Rs1wZ</a>
// Destination addresses: <a href="https://live.blockcypher.com/btc-testnet/address/n3D2YXwvpoPg8FhcWpzJiS3SvKKGD8AXZ4/">n3D2YXwvpoPg8FhcWpzJiS3SvKKGD8AXZ4</a>

/// For sample purposes only.
$request = clone $txSkeleton;

/// Send TX to the network
try {
    $output = $txClient->send($txSkeleton);
} catch (Exception $ex) {
    ResultPrinter::printError("Sent Transaction (spend multisig funds)", "TXSkeleton", null, $request, $ex);
    exit(1);
}

ResultPrinter::printResult("Sent Transaction (spend multisig funds)", "TXSkeleton", $output->getTx()->getHash(), $request, $output);

return $output;