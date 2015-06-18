<?php

// # Create TX Sample (without sending it)
//
// This sample code demonstrate how you can create a new transaction, as documented here at:
// <a href="http://dev.blockcypher.com/#creating-transactions">http://dev.blockcypher.com/#creating-transactions</a>
// API used: POST /v1/btc/main/txs/new

require __DIR__ . '/../bootstrap.php';

// Create a new instance of TX object
$tx = new \BlockCypher\Api\TX();

// ## partially-filled out TX request object.
// To use BlockCypher’s two-endpoint transaction creation tool, first you need to provide the input address(es),
// output address, and value to transfer (in satoshis). This is provided in the form of a partially-filled out
// TX request object.
//{
//  "inputs": [
//  {
//    "addresses": [
//      "n3D2YXwvpoPg8FhcWpzJiS3SvKKGD8AXZ4"
//    ]
//	}
//	],
//	"outputs": [
//	{
//    "addresses": [
//      "mvwhcFDFjmbDWCwVJ73b8DcG6bso3CZXDj"
//    ],
//    "value": 1000
//	}
//	]
//}

// Tx inputs
$input = new \BlockCypher\Api\TXInput();
$input->addAddress("n3D2YXwvpoPg8FhcWpzJiS3SvKKGD8AXZ4");
// https://live.blockcypher.com/btc-testnet/address/n3D2YXwvpoPg8FhcWpzJiS3SvKKGD8AXZ4/

// Tx outputs
$output = new \BlockCypher\Api\TXOutput();
$output->addAddress("mvwhcFDFjmbDWCwVJ73b8DcG6bso3CZXDj");
// https://live.blockcypher.com/btc-testnet/address/mvwhcFDFjmbDWCwVJ73b8DcG6bso3CZXDj/
$output->setValue(1000); // Satoshis

$tx->addInput($input);
$tx->addOutput($output);

// For Sample Purposes Only.
$request = clone $tx;

try {
    // ### Create New TX
    $output = $tx->create($apiContexts['BTC.test3']);
} catch (Exception $ex) {
    ResultPrinter::printError("Created TX", "TXSkeleton", null, $request, $ex);
    exit(1);
}

ResultPrinter::printResult("Created TX", "TXSkeleton", $output->getTx()->getHash(), $request, $output);

return $output;