<?php

// Run on console:
// php -f .\sample\transaction-api\NewTransactionEndpoint.php

require __DIR__ . '/../bootstrap.php';

use BlockCypher\Api\Transaction;
use BlockCypher\Auth\SimpleTokenCredential;
use BlockCypher\Rest\ApiContext;

$apiContext = ApiContext::create(
    'test', 'bcy', 'v1',
    new SimpleTokenCredential('c0afcccdde5081d6429de37d16166ead'),
    array('log.LogEnabled' => true, 'log.FileName' => 'BlockCypher.log', 'log.LogLevel' => 'DEBUG')
);

// Create a new instance of Transaction object
$tx = new Transaction();

// Tx inputs
$input = new \BlockCypher\Api\Input();
$input->addAddress("C5vqMGme4FThKnCY44gx1PLgWr86uxRbDm");
$tx->addInput($input);
// Tx outputs
$output = new \BlockCypher\Api\Output();
$output->addAddress("C4MYFr4EAdqEeUKxTnPUF3d3whWcPMz1Fi");
$tx->addOutput($output);
// Tx amount
$output->setValue(1000); // Satoshis

// For Sample Purposes Only.
$request = clone $tx;

// ### Create New Transaction
$output = $tx->create($apiContext);

ResultPrinter::printResult("New Transaction Endpoint", "TXSkeleton", $output->getTx()->getHash(), $request, $output);