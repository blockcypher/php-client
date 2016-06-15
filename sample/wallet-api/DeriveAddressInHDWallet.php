<?php

// # Derive New Address in a HD Wallet
//
// This sample code demonstrate how you can derive new addresses in a hd wallet,
// as documented here at <a href="http://dev.blockcypher.com/#derive-address-in-wallet-endpoint">docs</a>
//
// API used: GET /v1/btc/main/wallets/hd/Wallet-Name/addresses/derive

// In samples we are using CreateHDWallet.php sample to get the created instance of wallet.
// You have to run that sample before running this one or there will be no wallets

require __DIR__ . '/../bootstrap.php';

if (isset($_GET['wallet_name'])) {
    $walletName = filter_input(INPUT_GET, 'wallet_name', FILTER_SANITIZE_SPECIAL_CHARS);
} else {
    $walletName = 'bob'; // Default hd wallet name for samples
}

$walletClient = new \BlockCypher\Client\HDWalletClient($apiContexts['BTC.main']);

try {
    /// Generate new address
    $output = $walletClient->deriveAddress($walletName);
} catch (Exception $ex) {
    ResultPrinter::printError("Derive Address in a HDWallet", "HDWallet", $walletName, null, $ex);
    exit(1);
}

ResultPrinter::printResult("Derive Address in a HDWallet", "HDWallet", $walletName, null, $output);

return $output;
