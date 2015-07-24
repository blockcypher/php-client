<?php

// # Create HDWallet
// This sample code demonstrate how you can create a HD wallet, as documented here at
// <a href="http://dev.blockcypher.com/#create-wallet-endpoint">docs</a>.
//
// API used: POST /v1/btc/main/wallets/hd

require __DIR__ . '/../bootstrap.php';

if (isset($_GET['wallet_name'])) {
    $walletName = filter_input(INPUT_GET, 'wallet_name', FILTER_SANITIZE_SPECIAL_CHARS);
} else {
    $walletName = 'bob'; // Default wallet name for samples
}

$wallet = new \BlockCypher\Api\HDWallet();
$wallet->setName($walletName);
$wallet->setExtendedPublicKey('xpub661MyMwAqRbcFtXgS5sYJABqqG9YLmC4Q1Rdap9gSE8NqtwybGhePY2gZ29ESFjqJoCu1Rupje8YtGqsefD265TMg7usUDFdp6W1EGMcet8');
$wallet->setSubchainIndexes(array(1, 3));

/// For Sample Purposes Only.
$request = clone $wallet;

$walletClient = new \BlockCypher\Client\HDWalletClient($apiContexts['BTC.main']);

try {
    $output = $walletClient->create($wallet);
} catch (Exception $ex) {
    ResultPrinter::printError("Created HDWallet", "HDWallet", null, $request, $ex);
    exit(1);
}

ResultPrinter::printResult("Created HDWallet", "HDWallet", $output->getName(), $request, $output);

return $output;
