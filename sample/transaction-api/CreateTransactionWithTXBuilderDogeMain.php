<?php

// # Create TX Sample (without sending it)
//
// This sample code demonstrate how you can create a new transaction, as documented here at:
// <a href="http://dev.blockcypher.com/#creating-transactions">http://dev.blockcypher.com/#creating-transactions</a>
// Destination address is a multisig address.
// API used: POST /v1/doge/main/txs/new

require __DIR__ . '/../bootstrap.php';

// Create a new instance of TX object
$tx = new \BlockCypher\Api\TX();

$input = \BlockCypher\Builder\TXInputBuilder::aTXInput()
    ->addAddress("DGKpPALLfKA2bfTXQmHrUCBuNsX5DBGvjH")
    ->build();

$output = \BlockCypher\Builder\TXOutputBuilder::aTXOutput()
    ->addAddress("DJ4bg6Reh5CHZEGYEfWFj6ubPWNL693ngM")
    ->withValue(1000)
    ->build();

$tx = \BlockCypher\Builder\TXBuilder::aTX()
    ->addTXInput($input)
    ->addTXOutput($output)
    ->build();

// For Sample Purposes Only.
$request = clone $tx;

$txClient = new \BlockCypher\Client\TXClient($apiContexts['DOGE.main']);

try {
    // ### Create New TX
    $txSkeleton = $txClient->create($tx);
} catch (Exception $ex) {
    ResultPrinter::printError("Created TX Doge", "TXSkeleton", null, $request, $ex);
    exit(1);
}

ResultPrinter::printResult("Created TX Doge", "TXSkeleton", $txSkeleton->getTx()->getHash(), $request, $txSkeleton);

return $txSkeleton;