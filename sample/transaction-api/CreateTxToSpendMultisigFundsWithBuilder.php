<?php

// # Spend Multisig Funds (using builder)
//
// This sample code demonstrate how you can create a new transaction, as documented here at:
// <a href="http://dev.blockcypher.com/#creating-transactions">http://dev.blockcypher.com/#creating-transactions</a>
//
// Destination address is a multisig address.
//
// API used: POST /v1/btc/main/txs/new
//
// This sample uses builders classes (optional).

require __DIR__ . '/../bootstrap.php';

// BTC-TESTNET: 2NBbY8fbHRLjWXHqRvs8P996N82eTYic1yX
$input = \BlockCypher\Builder\TXInputBuilder::aTXInput()
    ->addAddress("033e88a5503dc09243e58d9e7a53831c2b77cac014415ad8c29cabab5d933894c1")
    ->addAddress("02087f346641256d4ba19cc0473afaa8d3d1b903761b9220a915e1af65a12e613c")
    ->addAddress("03051fa1586ff8d509125d3e25308b4c66fcf656b377bf60bfdb296a4898d42efd")
    ->withScryptType("multisig-2-of-3")
    ->build();

$output = \BlockCypher\Builder\TXOutputBuilder::aTXOutput()
    ->addAddress("n3D2YXwvpoPg8FhcWpzJiS3SvKKGD8AXZ4")
    ->withValue(1000)
    ->build();

$tx = \BlockCypher\Builder\TXBuilder::aTX()
    ->addTXInput($input)
    ->addTXOutput($output)
    ->build();

/// For Sample Purposes Only.
$request = clone $tx;

$txClient = new \BlockCypher\Client\TXClient($apiContexts['BTC.test3']);

try {
    $txSkeleton = $txClient->create($tx);
} catch (\Exception $ex) {
    ResultPrinter::printError("Created Multisig TX (Spend Multisig Fund)", "TXSkeleton", null, $request, $ex);
    exit(1);
}

ResultPrinter::printResult("Created Multisig TX (Spend Multisig Fund)", "TXSkeleton", $txSkeleton->getTx()->getHash(), $tx, $txSkeleton);