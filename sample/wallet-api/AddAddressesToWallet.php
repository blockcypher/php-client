<?php

// # Add Addresses to Wallet
//
// This sample code demonstrate how you can add addresses to a wallet, as documented here at:
// <a href="http://dev.blockcypher.com/#wallets">http://dev.blockcypher.com/#wallets</a>
//
// API used: GET /v1/btc/main/wallets/Wallet-Name/addresses

// In samples we are using CreateWallet.php sample to get the created instance of wallet.
// You have to run that sample before running this one or there will be no wallets

require __DIR__ . '/../bootstrap.php';

if (isset($_GET['wallet_name'])) {
    $walletName = filter_input(INPUT_GET, 'wallet_name', FILTER_SANITIZE_SPECIAL_CHARS);
} else {
    $walletName = 'alice'; // Default wallet name for samples
}

$walletClient = new \BlockCypher\Client\WalletClient($apiContexts['BTC.main']);

$addressList = \BlockCypher\Api\AddressList::fromAddressesArray(array(
    "13cj1QtfW61kQHoqXm3khVRYPJrgQiRM6j"
));

try {
    /// Add addresses to Wallet
    $output = $walletClient->addAddresses($walletName, $addressList);
} catch (Exception $ex) {
    ResultPrinter::printError("Add Addresses to a Wallet", "Wallet", $walletName, $addressList, $ex);
    exit(1);
}

ResultPrinter::printResult("Add Addresses to a Wallet", "Wallet", $walletName, $addressList, $output);

return $output;
