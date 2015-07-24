<?php

// # Delete Wallet
//
// This sample code demonstrate how you can delete a wallet, as documented here at:
// <a href="http://dev.blockcypher.com/#wallets">http://dev.blockcypher.com/#wallets</a>
//
// API used: DELETE /v1/btc/main/wallets/Wallet-Name

require __DIR__ . '/../bootstrap.php';

// Delete a new instance of Wallet object.
// First you have to run CreateWallet sample to create "alice" wallet

if (isset($_GET['wallet_name'])) {
    $walletName = filter_input(INPUT_GET, 'wallet_name', FILTER_SANITIZE_SPECIAL_CHARS);
} else {
    $walletName = 'alice'; // Default wallet name for samples
}

$walletClient = new \BlockCypher\Client\WalletClient($apiContexts['BTC.main']);

try {
    /// Delete the Wallet
    $output = $walletClient->delete($walletName);
} catch (Exception $ex) {
    ResultPrinter::printError("Deleted Wallet", "Wallet", $walletName, null, $ex);
    exit(1);
}

ResultPrinter::printResult("Deleted Wallet", "Wallet", $walletName, null, $output);

return $output;