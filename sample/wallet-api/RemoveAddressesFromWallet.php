<?php

// # Remove Addresses from Wallet
//
// This sample code demonstrate how you can removes addresses from a wallet, as documented here at:
// <a href="http://dev.blockcypher.com/#wallets">http://dev.blockcypher.com/#wallets</a>
//
// API used: DELETE /v1/btc/main/wallets/Wallet-Name/addresses?address=13cj1Qtf...gQiRM6j

// In samples we are using CreateWallet.php sample to get the created instance of wallet
// and AddAddressesToWallet to add the address which is going to be removed.
// You have to run that sample before running this one.

require __DIR__ . '/../bootstrap.php';

if (isset($_GET['wallet_name'])) {
    $walletName = filter_input(INPUT_GET, 'wallet_name', FILTER_SANITIZE_SPECIAL_CHARS);
} else {
    $walletName = 'alice'; // Default wallet name for samples
}

$walletClient = new \BlockCypher\Client\WalletClient($apiContexts['BTC.main']);

/// List of addresses to be removed from the wallet
$addressList = \BlockCypher\Api\AddressList::fromAddressesArray(array(
    "13cj1QtfW61kQHoqXm3khVRYPJrgQiRM6j"
));

try {
    /// Remove addresses from wallet
    $output = $walletClient->removeAddresses($walletName, $addressList);
} catch (Exception $ex) {
    ResultPrinter::printError("Remove Addresses from a Wallet", "Wallet", $walletName, $addressList, $ex);
    exit(1);
}

ResultPrinter::printResult("Remove Addresses from a Wallet", "Wallet", $walletName, $addressList, $output);

return $output;
