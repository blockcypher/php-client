<?php

// # Get All HD Wallet Addresses
//
// Use this call to list all the hd wallet addresses, as documented here at
// <a href="http://dev.blockcypher.com/#wallets">docs</a>
//
// API used: GET /v1/btc/main/wallets/hd/<Wallet-Name>/addresses?token=<Your-Token>

// In samples we are using CreateHDWallet.php sample to get the created instance of wallet.
// You have to run that sample before running this one or there will be no wallets

require __DIR__ . '/../bootstrap.php';

if (isset($_GET['wallet_name'])) {
    $walletName = filter_input(INPUT_GET, 'wallet_name', FILTER_SANITIZE_SPECIAL_CHARS);
} else {
    $walletName = 'bob'; // Default hd wallet name for samples
}

try {
    $output = \BlockCypher\Api\HDWallet::getOnlyAddresses($walletName, array(), $apiContexts['BTC.main']);
} catch (Exception $ex) {
    ResultPrinter::printError("List all HDWallet addresses", "HDWallet", $walletName, null, $ex);
    exit(1);
}

ResultPrinter::printResult("List all HDWallet addresses", "HDWallet", $walletName, null, $output);

return $output;
