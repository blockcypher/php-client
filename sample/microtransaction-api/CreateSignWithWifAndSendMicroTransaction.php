<?php

// # Create, Sign (WIF) and Send MicroTX
// This sample code demonstrate how you can create, sign and send a new microtransaction, as documented here at:
// <a href="http://dev.blockcypher.com/#microtransaction-endpoint">http://dev.blockcypher.com/#microtransaction-endpoint</a>
//
// API used: POST /v1/btc/main/txs/micro

require __DIR__ . '/../bootstrap.php';

/// New MicroTX
$microTX = new \BlockCypher\Api\MicroTX();
$microTX->setFromPubkey("02d4e3404e175923adf89c932fab96758716f6a0a896890f2494c5d9141eb3f543")
    ->setToAddress("C4MYFr4EAdqEeUKxTnPUF3d3whWcPMz1Fi")
    ->setValueSatoshis(10000);

$microTXClient = new \BlockCypher\Client\MicroTXClient($apiContexts['BCY.test']);

try {
    /// Create
    $microTXToSign = $microTXClient->create($microTX);

    ResultPrinter::printResult("Created MicroTX", "MicroTX", $microTXToSign->getHash(), $microTX, $microTXToSign);

    /// Sign
    $microTXSigned = $microTXToSign->sign("BpouCdZ5dXbjcUDQBj8ZVYBbSPtWYDQHxuDcP48VA6Q7dZuqW4UJ"); // WIF

    /// Send
    $microTXSent = $microTXClient->send($microTXSigned);

    ResultPrinter::printResult("Send MicroTX", "MicroTX", $microTXSent->getHash(), $microTXSigned, $microTXSent);

} catch (Exception $ex) {
    ResultPrinter::printError("Created, Sign and Send MicroTX", "MicroTX", null, null, $ex);
    exit(1);
}