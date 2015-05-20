<?php

// # Delete Wallet Sample
//
// This sample code demonstrate how you can delete a wallet, as documented here at:
// <a href="http://dev.blockcypher.com/#wallet_api">http://dev.blockcypher.com/#wallet_api</a>
// API used: DELETE /v1/btc/main/wallets/Wallet-Name

require __DIR__ . '/../bootstrap.php';

// Delete a new instance of Wallet object
// First you have to run CreateWallet sample to create "alice" wallet

if (isset($_GET['wallet_name'])) {
    $walletName = filter_input(INPUT_GET, 'wallet_name', FILTER_SANITIZE_SPECIAL_CHARS);
} else {
    $walletName = 'alice'; // Default wallet name for samples
}

// ### Delete Wallet
try {
    // Get the Wallet
    $wallet = \BlockCypher\Api\Wallet::get($walletName, array(), $apiContexts['BTC.main']);

    // Delete the Wallet
    $output = $wallet->delete(array(), $apiContexts['BTC.main']);
} catch (Exception $ex) {
    ResultPrinter::printError("Deleted Wallet", "Wallet", $walletName, null, $ex);
    exit(1);
}

ResultPrinter::printResult("Deleted Wallet", "Wallet", $walletName, null, $output);

return $output;