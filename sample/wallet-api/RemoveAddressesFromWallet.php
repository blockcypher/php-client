<?php

// # Remove Addresses from Wallet Sample
//
// This sample code demonstrate how you can removes addresses from a wallet, as documented here at:
// <a href="http://dev.blockcypher.com/#wallet_api">http://dev.blockcypher.com/#wallet_api</a>
// API used: GET /v1/btc/main/wallets/Wallet-Name/addresses

// ## Get Wallet Name and Add Addresses.
// In samples we are using CreateWallet.php sample to get the created instance of wallet
// and AddAddressesToWallet to add the address which is going to be removed.
// You have to run that sample before running this one.

require __DIR__ . '/../bootstrap.php';

// Wallet must be created previously
if (isset($_GET['wallet_name'])) {
    $walletName = filter_input(INPUT_GET, 'wallet_name', FILTER_SANITIZE_SPECIAL_CHARS);
} else {
    $walletName = 'alice'; // Default wallet name for samples
}

// List of addresses to be removed from the wallet
$addressesList = \BlockCypher\Api\AddressesList::fromAddressesArray(array(
    "13cj1QtfW61kQHoqXm3khVRYPJrgQiRM6j"
));

// ### Remove Addresses from the Wallet
try {
    // Get Wallet
    $wallet = \BlockCypher\Api\Wallet::get($walletName, array(), $apiContexts['BTC.main']);
    // Remove addresses
    $output = $wallet->removeAddresses($addressesList, array(), $apiContexts['BTC.main']);
} catch (Exception $ex) {
    ResultPrinter::printError("Remove Addresses from a Wallet", "Wallet", $walletName, $addressesList, $ex);
    exit(1);
}

ResultPrinter::printResult("Remove Addresses from a Wallet", "Wallet", $walletName, $addressesList, $output);

return $output;
