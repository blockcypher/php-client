<?php

// # Create TX Sample (without sending it)
//
// This sample code demonstrate how you can create a new transaction, as documented here at:
// <a href="http://dev.blockcypher.com/#creating-transactions">http://dev.blockcypher.com/#creating-transactions</a>
// Destination address is a multisig address.
// API used: POST /v1/bcy/test/txs/new

require __DIR__ . '/../bootstrap.php';

// Create a new instance of TX object
$tx = new \BlockCypher\Api\TX();

$input = \BlockCypher\Builder\TXInputBuilder::aTXInput()
    ->addAddress("C5vqMGme4FThKnCY44gx1PLgWr86uxRbDm")
    ->build();

$output = \BlockCypher\Builder\TXOutputBuilder::aTXOutput()
    ->addAddress("C4MYFr4EAdqEeUKxTnPUF3d3whWcPMz1Fi")
    ->withValue(1000)
    ->build();

$tx = \BlockCypher\Builder\TXBuilder::aTX()
    ->addTXInput($input)
    ->addTXOutput($output)
    ->build();

// For Sample Purposes Only.
$request = clone $tx;

$txClient = new \BlockCypher\Client\TXClient($apiContexts['BCY.test']);

try {
    // ### Create New TX
    $txSkeleton = $txClient->create($tx);
} catch (Exception $ex) {
    ResultPrinter::printError("Created TX BlockCypher Testnet", "TXSkeleton", null, $request, $ex);
    exit(1);
}

ResultPrinter::printResult("Created TX BlockCypher Testnet", "TXSkeleton", $txSkeleton->getTx()->getHash(), $request, $txSkeleton);

return $txSkeleton;