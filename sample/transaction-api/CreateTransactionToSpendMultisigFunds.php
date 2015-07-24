<?php

// # Create TX Sample (without sending it)
//
// This sample code demonstrate how you can create a new transaction, as documented at <a href="http://dev.blockcypher.com/?#multisig-transactions">docs</a>.
// Source address is a multisig address.
//
// API used: POST /v1/btc/main/txs/new
//

require __DIR__ . '/../bootstrap.php';

$tx = new \BlockCypher\Api\TX();

// Source address: <a href="https://live.blockcypher.com/btc-testnet/address/2Mu7dJvawNdhshTkKRXGAVLKdr2VA7Rs1wZ/">2Mu7dJvawNdhshTkKRXGAVLKdr2VA7Rs1wZ</a>
$input = new \BlockCypher\Api\TXInput();
$input->setAddresses(array(
    "033e88a5503dc09243e58d9e7a53831c2b77cac014415ad8c29cabab5d933894c1",
    "02087f346641256d4ba19cc0473afaa8d3d1b903761b9220a915e1af65a12e613c",
    "03051fa1586ff8d509125d3e25308b4c66fcf656b377bf60bfdb296a4898d42efd"
));
$input->setScriptType("multisig-2-of-3");

// Destination address: <a href="https://live.blockcypher.com/btc-testnet/address/n3D2YXwvpoPg8FhcWpzJiS3SvKKGD8AXZ4/">n3D2YXwvpoPg8FhcWpzJiS3SvKKGD8AXZ4</a>
$output = new \BlockCypher\Api\TXOutput();
$output->addAddress("n3D2YXwvpoPg8FhcWpzJiS3SvKKGD8AXZ4");
$output->setValue(1000); // Satoshis

$tx->addInput($input);
$tx->addOutput($output);

/// For Sample Purposes Only.
$request = clone $tx;

$txClient = new \BlockCypher\Client\TXClient($apiContexts['BTC.test3']);

/// Create New TX
try {
    $txSkeleton = $txClient->create($tx);
} catch (Exception $ex) {
    ResultPrinter::printError("Created Multisig TX (spend multisig fund)", "TXSkeleton", null, $request, $ex);
    exit(1);
}

ResultPrinter::printResult("Created Multisig TX (spend multisig fund)", "TXSkeleton", $txSkeleton->getTx()->getHash(), $request, $txSkeleton);

return $txSkeleton;

/// ## partially-filled out TX request object.
/// To use BlockCypher’s two-endpoint transaction creation tool, first you need to provide the input address(es),
/// output address, and value to transfer (in satoshis). This is provided in the form of a partially-filled out
/// TX request object.
///{
///  "inputs":[
///    {
///      "addresses":[
///        "03798be8162d7d6bc5c4e3b236100fcc0dfee899130f84c97d3a49faf83450fd81",
///        "03dd9f1d4a39951013b4305bf61887ada66439ab84a9a2f8aca9dc736041f815f1",
///        "03c8e6e99c1d0b42120d5cf40c963e5e8048fd2d2a184758784a041a9d101f1f02"
///      ],
///      "script_type":"multisig-2-of-3",
///    }
///  ],
///  "outputs":[
///    {
///      "addresses":[
///        "n3D2YXwvpoPg8FhcWpzJiS3SvKKGD8AXZ4"
///      ],
///      "value":1000
///    }
///  ]
///}