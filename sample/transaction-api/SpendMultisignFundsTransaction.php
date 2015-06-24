<?php

// # Spend Multisign Funds Sample
//
// This sample code demonstrate how you can create a new transaction and send it to the network
// to spend fund from multisign address, as documented here at:
// <a href="http://dev.blockcypher.com/?javascript#multisig-transactions">http://dev.blockcypher.com/?javascript#multisig-transactions</a>
// API used: POST /v1/btc/main/txs/new and
// POST /v1/btc/main/txs/send

/** @var \BlockCypher\Api\TXSkeleton $txSkeleton */
$txSkeleton = require 'CreateTransactionToSpendMultisignFunds.php';

// DEBUG
//var_dump($txSkeleton);
//die();

// source addresses private keys
// private key in the same format as returned by Generate Address Endpoint:
// http://dev.blockcypher.com/?shell#generate-address-endpoint
// Private keys, at least 2 of 3:
$privateKeys = array(
    "a2d2a8aa1cb1dbf7780d99aece481be1cd7d79427618a6091cf9b0d9d1244210",
    "d6dd853fa8c294c8178eac620fb7c58e98813dcf3a85c012786280bab4662ed8"
    //"b0b730309a90eabc7681a47facf3f8bcaeb68668d2eaf8a2fe52682144d61418"
);

// ### Sign the TX
$txSkeleton->sign($privateKeys, $apiContexts['BTC.test3']);

// Source (multisign) and destination addresses used in this sample
// https://live.blockcypher.com/btc-testnet/address/2Mu7dJvawNdhshTkKRXGAVLKdr2VA7Rs1wZ/
// https://live.blockcypher.com/btc-testnet/address/n3D2YXwvpoPg8FhcWpzJiS3SvKKGD8AXZ4/

// For sample purposes only.
$request = clone $txSkeleton;

try {
    // ### Send TX to the network
    $output = $txSkeleton->send($apiContexts['BTC.test3']);
} catch (Exception $ex) {
    ResultPrinter::printError("Sent Transaction (spend multisign funds)", "TXSkeleton", null, $request, $ex);
    exit(1);
}

ResultPrinter::printResult("Sent Transaction (spend multisign funds)", "TXSkeleton", $output->getTx()->getHash(), $request, $output);

return $output;