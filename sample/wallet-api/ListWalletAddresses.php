<?php

// # Get All Wallet Addresses
//
// Use this call to list all the wallet addresses, as documented here at:
// <a href="http://dev.blockcypher.com/#wallets">http://dev.blockcypher.com/#wallets</a>
//
// API used: GET /v1/btc/main/wallets/<Wallet-Name>/addresses?token=<Your-Token>

// In samples we are using CreateWallet.php sample to get the created instance of wallet.
// You have to run that sample before running this one or there will be no wallets

require __DIR__ . '/../bootstrap.php';

if (isset($_GET['wallet_name'])) {
    $walletName = filter_input(INPUT_GET, 'wallet_name', FILTER_SANITIZE_SPECIAL_CHARS);
} else {
    $walletName = 'alice'; // Default wallet name for samples
}

$walletClient = new \BlockCypher\Client\WalletClient($apiContexts['BTC.main']);

try {
    $output = $walletClient->getWalletAddresses($walletName);
} catch (Exception $ex) {
    ResultPrinter::printError("List all Wallet addresses", "Wallet", $walletName, null, $ex);
    exit(1);
}

ResultPrinter::printResult("List all Wallet addresses", "Wallet", $walletName, null, $output);

return $output;
