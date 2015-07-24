<?php

// # Delete HDWallet
//
// This sample code demonstrate how you can delete a HD wallet, as documented here at
// <a href="http://dev.blockcypher.com/#delete-wallet-endpoint">docs</a>
//
// API used: DELETE /v1/btc/main/wallets/hd/Wallet-Name

require __DIR__ . '/../bootstrap.php';

// Delete a new instance of HDWallet object.
// First you have to run CreateHDWallet sample to create "bob" wallet

if (isset($_GET['wallet_name'])) {
    $walletName = filter_input(INPUT_GET, 'wallet_name', FILTER_SANITIZE_SPECIAL_CHARS);
} else {
    $walletName = 'bob'; // Default wallet name for samples
}

$walletClient = new \BlockCypher\Client\HDWalletClient($apiContexts['BTC.main']);

try {
    /// Delete the HDWallet
    $output = $walletClient->delete($walletName);
} catch (Exception $ex) {
    ResultPrinter::printError("Deleted HDWallet", "HDWallet", $walletName, null, $ex);
    exit(1);
}

ResultPrinter::printResult("Deleted HDWallet", "HDWallet", $walletName, null, $output);

return $output;