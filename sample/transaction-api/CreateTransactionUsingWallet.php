<?php

// # Create TX from wallet (without sending it)
//
// This sample code demonstrate how you can create a new transaction, as documented here at:
// <a href="http://dev.blockcypher.com/#creating-transactions">http://dev.blockcypher.com/#creating-transactions</a>
//
// API used: POST /v1/btc/main/txs/new

// Source wallet:
// <a href="http://api.blockcypher.com/v1/btc/main/addrs/5596926E976A1149871172?token=c0afcccdde5081d6429de37d16166ead">5596926E976A1149871172</a>
// Destination address:
// <a href="https://live.blockcypher.com/btc-testnet/address/mvwhcFDFjmbDWCwVJ73b8DcG6bso3CZXDj/">mvwhcFDFjmbDWCwVJ73b8DcG6bso3CZXDj</a>

require __DIR__ . '/../bootstrap.php';

/// Tx inputs
$input = new \BlockCypher\Api\TXInput();
$input->setWalletName("5596926E976A1149871172");
//$input->setWalletName("AC33394F28292099183");
$input->setWalletToken("c0afcccdde5081d6429de37d16166ead");

/// Tx outputs
$output = new \BlockCypher\Api\TXOutput();
$output->addAddress("mvwhcFDFjmbDWCwVJ73b8DcG6bso3CZXDj");
$output->setValue(1000); // Satoshis

/// Tx
$tx = new \BlockCypher\Api\TX();
$tx->addInput($input);
$tx->addOutput($output);

/// For Sample Purposes Only.
$request = clone $tx;

$txClient = new \BlockCypher\Client\TXClient($apiContexts['BTC.test3']);

try {
    $output = $txClient->create($tx);

} catch (\BlockCypher\Exception\BlockCypherConnectionException $ex) {
    $data = $ex->getData();
    $txSkeleton = new \BlockCypher\Api\TXSkeleton($data);

    ResultPrinter::printError("Created TX", "TXSkeleton", null, $request, $ex);
    exit(1);

} catch (\Exception $ex) {
    ResultPrinter::printError("Created TX", "TXSkeleton", null, $request, $ex);
    exit(1);
}

ResultPrinter::printResult("Created TX", "TXSkeleton", $output->getTx()->getHash(), $request, $output);

return $output;