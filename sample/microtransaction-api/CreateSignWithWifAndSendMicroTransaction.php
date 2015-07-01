<?php

// # Create, Sign (WIF) and Send MicroTX
// This sample code demonstrate how you can create, sign and send a new microtransaction, as documented here at:
// <a href="http://dev.blockcypher.com/#microtransaction-endpoint">http://dev.blockcypher.com/#microtransaction-endpoint</a>
//
// API used: POST /v1/btc/main/txs/micro

require __DIR__ . '/../bootstrap.php';

$microTX = new \BlockCypher\Api\MicroTX();

try {
    /// Create, Sign and Send a MicroTX
    $microTX->setFromPubkey("02d4e3404e175923adf89c932fab96758716f6a0a896890f2494c5d9141eb3f543")
        ->setToAddress("C4MYFr4EAdqEeUKxTnPUF3d3whWcPMz1Fi")
        ->setValueSatoshis(10000)
        ->create($apiContexts['BCY.test'])
        ->sign("BpouCdZ5dXbjcUDQBj8ZVYBbSPtWYDQHxuDcP48VA6Q7dZuqW4UJ") // WIF
        ->send($apiContexts['BCY.test']);
} catch (Exception $ex) {
    ResultPrinter::printError("Created, Sign (Wif) and Send MicroTX", "MicroTX", null, null, $ex);
    exit(1);
}

ResultPrinter::printResult("Created, Sign (Wif) and Send MicroTX", "MicroTX", $microTX->getHash(), null, $microTX);