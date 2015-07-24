<?php

// # Get HDWallet
//
// This sample code demonstrate how you can get a HD wallet, as documented here at
// <a href="http://dev.blockcypher.com/#wallets">docs</a>
//
// API used: GET /v1/btc/main/wallets/hd/HDWallet-Name

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
    $output = $walletClient->get($walletName);
} catch (Exception $ex) {
    ResultPrinter::printError("Get a HDWallet", "HDWallet", null, $walletName, $ex);
    exit(1);
}

ResultPrinter::printResult("Get a HDWallet", "HDWallet", $output->getName(), null, $output);

return $output;
