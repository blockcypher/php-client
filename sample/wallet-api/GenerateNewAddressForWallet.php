<?php

// # Generate a new Addresses and associated to Wallet Sample
//
// This sample code demonstrate how you can generate a new addresses and associated it to a wallet, as documented here at:
// <a href="http://dev.blockcypher.com/#wallet_api">http://dev.blockcypher.com/#wallet_api</a>
// API used: GET /v1/btc/main/wallets/Wallet-Name/addresses/generate

// ## Get Wallet Name.
// In samples we are using CreateWallet.php sample to get the created instance of wallet.
// You have to run that sample before running this one or there will be no wallets

require __DIR__ . '/../bootstrap.php';

// Wallet must be created previously
if (isset($_GET['wallet_name'])) {
    $walletName = filter_input(INPUT_GET, 'wallet_name', FILTER_SANITIZE_SPECIAL_CHARS);
} else {
    $walletName = 'alice'; // Default wallet name for samples
}

// ### Generate new address and associated it to the Wallet
try {
    // Get Wallet
    $wallet = \BlockCypher\Api\Wallet::get($walletName, array(), $apiContexts['BTC.main']);
    // Add addresses
    $output = $wallet->generateAddress(array(), $apiContexts['BTC.main']);
} catch (Exception $ex) {
    ResultPrinter::printError("Add Addresses to a Wallet", "WalletGenerateAddressResponse", $walletName, null, $ex);
    exit(1);
}

ResultPrinter::printResult("Add Addresses to a Wallet", "WalletGenerateAddressResponse", $walletName, null, $output);

return $output;
