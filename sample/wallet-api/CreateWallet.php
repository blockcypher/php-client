<?php

// # Create Wallet
// This sample code demonstrate how you can create a wallet, as documented here at:
// <a href="http://dev.blockcypher.com/#wallet_api">http://dev.blockcypher.com/#wallet_api</a>
//
// API used: POST /v1/btc/main/wallets

require __DIR__ . '/../bootstrap.php';

if (isset($_GET['wallet_name'])) {
    $walletName = filter_input(INPUT_GET, 'wallet_name', FILTER_SANITIZE_SPECIAL_CHARS);
} else {
    $walletName = 'alice'; // Default wallet name for samples
}

$wallet = new \BlockCypher\Api\Wallet();
$wallet->setName($walletName);
$wallet->setAddresses(array(
    "1JcX75oraJEmzXXHpDjRctw3BX6qDmFM8e"
));

/// For Sample Purposes Only.
$request = clone $wallet;

$walletClient = new \BlockCypher\Client\WalletClient($apiContexts['BTC.main']);

try {
    $output = $walletClient->create($wallet);
} catch (Exception $ex) {
    ResultPrinter::printError("Created Wallet", "Wallet", null, $request, $ex);
    exit(1);
}

ResultPrinter::printResult("Created Wallet", "Wallet", $output->getName(), $request, $output);

return $output;
