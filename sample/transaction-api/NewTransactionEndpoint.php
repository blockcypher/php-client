<?php

// Run on console:
// php -f .\sample\transaction-api\NewTransactionEndpoint.php

require __DIR__ . '/../bootstrap.php';

use BlockCypher\Api\TX;
use BlockCypher\Auth\SimpleTokenCredential;
use BlockCypher\Client\TXClient;
use BlockCypher\Rest\ApiContext;

$apiContext = ApiContext::create(
    'test', 'bcy', 'v1',
    new SimpleTokenCredential('c0afcccdde5081d6429de37d16166ead'),
    array('mode' => 'sandbox', 'log.LogEnabled' => true, 'log.FileName' => 'BlockCypher.log', 'log.LogLevel' => 'DEBUG')
);

// Create a new instance of TX object
$tx = new TX();

// Tx inputs
$input = new \BlockCypher\Api\TXInput();
$input->addAddress("C5vqMGme4FThKnCY44gx1PLgWr86uxRbDm");
$tx->addInput($input);
// Tx outputs
$output = new \BlockCypher\Api\TXOutput();
$output->addAddress("C4MYFr4EAdqEeUKxTnPUF3d3whWcPMz1Fi");
$tx->addOutput($output);
// Tx amount
$output->setValue(1000); // Satoshis

// For Sample Purposes Only.
$request = clone $tx;

$txClient = new TXClient($apiContext);
$txSkeleton = $txClient->create($tx);

ResultPrinter::printResult("New TX Endpoint", "TXSkeleton", $txSkeleton->getTx()->getHash(), $request, $txSkeleton);