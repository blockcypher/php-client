<?php

// # Create TX Sample (without sending it)
//
// This sample code demonstrate how you can create a new transaction, as documented here at:
// <a href="http://dev.blockcypher.com/#creating-transactions">http://dev.blockcypher.com/#creating-transactions</a>
// Destination address is a multisig address.
// API used: POST /v1/btc/main/txs/new

require __DIR__ . '/../bootstrap.php';

// Create a new instance of TX object
$tx = new \BlockCypher\Api\TX();

// ## partially-filled out TX request object.
// To use BlockCypher’s two-endpoint transaction creation tool, first you need to provide the input address(es),
// output address, and value to transfer (in satoshis). This is provided in the form of a partially-filled out
// TX request object.
//{
//  "inputs":[
//    {
//      "addresses":"n3D2YXwvpoPg8FhcWpzJiS3SvKKGD8AXZ4"
//    }
//  ],
//  "outputs":[
//    {
//      "addresses":[
//        "03798be8162d7d6bc5c4e3b236100fcc0dfee899130f84c97d3a49faf83450fd81",
//        "03dd9f1d4a39951013b4305bf61887ada66439ab84a9a2f8aca9dc736041f815f1",
//        "03c8e6e99c1d0b42120d5cf40c963e5e8048fd2d2a184758784a041a9d101f1f02"
//      ],
//      "script_type":"multisig-2-of-3",
//      "value":1000
//    }
//  ]
//}

$input = \BlockCypher\Builder\TXInputBuilder::aTXInput()
    ->addAddress("n3D2YXwvpoPg8FhcWpzJiS3SvKKGD8AXZ4")
    ->build();

$output = \BlockCypher\Builder\TXOutputBuilder::aTXOutput()
    ->withScryptType("multisig-2-of-3")
    ->withValue(1000)
    ->addAddress("03798be8162d7d6bc5c4e3b236100fcc0dfee899130f84c97d3a49faf83450fd81")
    ->addAddress("03dd9f1d4a39951013b4305bf61887ada66439ab84a9a2f8aca9dc736041f815f1")
    ->addAddress("03c8e6e99c1d0b42120d5cf40c963e5e8048fd2d2a184758784a041a9d101f1f02")
    ->build();

$tx = \BlockCypher\Builder\TXBuilder::aTX()
    ->addTXInput($input)
    ->addTXOutput($output)
    ->build();

// For Sample Purposes Only.
$request = clone $tx;

$txClient = new \BlockCypher\Client\TXClient($apiContexts['BTC.test3']);

try {
    // ### Create New TX
    $txSkeleton = $txClient->create($tx);
} catch (Exception $ex) {
    ResultPrinter::printError("Created Multisig TX", "TXSkeleton", null, $request, $ex);
    exit(1);
}

ResultPrinter::printResult("Created Multisig TX", "TXSkeleton", $txSkeleton->getTx()->getHash(), $request, $txSkeleton);

return $txSkeleton;