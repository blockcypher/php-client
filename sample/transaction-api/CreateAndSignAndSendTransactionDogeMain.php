<?php

// # Create, Sign and Send TX Sample
//
// This sample code demonstrate how you can create a new transaction and send it to the network, as documented here at:
// <a href="http://dev.blockcypher.com/#creating-transactions">http://dev.blockcypher.com/#creating-transactions</a>
// API used: POST /v1/doge/main/txs/new and
// POST /v1/doge/main/txs/send

/** @var \BlockCypher\Api\TXSkeleton $txSkeleton */
$txSkeleton = require 'CreateTransactionWithTXBuilderDogeMain.php';

$txClient = new \BlockCypher\Client\TXClient($apiContexts['DOGE.main']);

// source addresses private keys
// private key in the same format as returned by Generate Address Endpoint:
// http://dev.blockcypher.com/?shell#generate-address-endpoint
$privateKeys = array(
    "be0a3742dddd1f30ddcfb2f8135db55ebd4b3b8ed84e59501edaf3d180b6bcff" // Address: DGKpPALLfKA2bfTXQmHrUCBuNsX5DBGvjH
);

// ### Sign the TX
try {
    $txSkeleton = $txClient->sign($txSkeleton, $privateKeys);
} catch (Exception $ex) {
    ResultPrinter::printError("Sign Transaction DOGE", "TXSkeleton", null, $request, $ex);
    exit(1);
}
// Source and Destination addresses used in this sample
// https://live.blockcypher.com/doge/address/DGKpPALLfKA2bfTXQmHrUCBuNsX5DBGvjH/
// https://live.blockcypher.com/doge/address/DJ4bg6Reh5CHZEGYEfWFj6ubPWNL693ngM/

// For sample purposes only.
$request = clone $txSkeleton;

try {
    // ### Send TX to the network
    $txSkeleton = $txClient->send($txSkeleton);
} catch (Exception $ex) {
    ResultPrinter::printError("Send Transaction DOGE", "TXSkeleton", null, $request, $ex);
    exit(1);
}

ResultPrinter::printResult("Send Transaction DOGE", "TXSkeleton", $txSkeleton->getTx()->getHash(), $request, $txSkeleton);