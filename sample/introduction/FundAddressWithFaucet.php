<?php

// # Fund Address with Faucet
// The Faucet allows you to fund test addresses.
// API called: '/v1/btc/test3' or  '/v1/bcy/test'

require __DIR__ . '/../bootstrap.php';

// The following code takes you through
// the process of funding a test address

// (See bootstrap.php for more on `ApiContext`)
try {
    /// ### Fund Address
    $faucetResponse = \BlockCypher\Api\Faucet::fundAddress('CFqoZmZ3ePwK5wnkhxJjJAQKJ82C7RJdmd', 100000, $apiContexts['BCY.test']);
} catch (Exception $ex) {
    ResultPrinter::printError("Fund Bcy Test Address", "FaucetResponse", null, null, $ex);
    exit(1);
}

// For Sample Purposes Only.
$faucet = new \BlockCypher\Api\Faucet();
$faucet->setAddress('CFqoZmZ3ePwK5wnkhxJjJAQKJ82C7RJdmd');
$faucet->setAmount(100000);

ResultPrinter::printResult("Fund Bcy Test Address", "FaucetResponse", null, $faucet, $faucetResponse);

return $faucetResponse;