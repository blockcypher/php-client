<?php

// # Fund Address with Faucet
// The Faucet allows you to fund test addresses.
// We offer two different options for testing your blockchain application:
// Bitcoin Testnet3, and BlockCypher’s Test Chain. We offer automated faucets for both Testnet3 and
// BlockCypher’s Test Chain.
// Read more info about <a href="http://dev.blockcypher.com/#testing">testing</a> in our docs.
//
// API called: '/v1/btc/test3' or '/v1/bcy/test'

require __DIR__ . '/../bootstrap.php';

$faucetClient = new \BlockCypher\Client\FaucetClient($apiContexts['BCY.test']);

try {
    $faucetResponse = $faucetClient->fundAddress('CFqoZmZ3ePwK5wnkhxJjJAQKJ82C7RJdmd', 100000);
} catch (Exception $ex) {
    ResultPrinter::printError("Fund Bcy Test Address", "FaucetResponse", null, null, $ex);
    exit(1);
}

/// For Sample Purposes Only.
$faucet = new \BlockCypher\Api\Faucet();
$faucet->setAddress('CFqoZmZ3ePwK5wnkhxJjJAQKJ82C7RJdmd');
$faucet->setAmount(100000);

ResultPrinter::printResult("Fund Bcy Test Address", "FaucetResponse", null, $faucet, $faucetResponse);

return $faucetResponse;