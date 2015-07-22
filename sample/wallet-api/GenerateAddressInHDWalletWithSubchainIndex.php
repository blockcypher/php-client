<?php

// # Generate New Address in a HD Wallet
//
// This sample code demonstrate how you can generate new addresses in a hd wallet,
// as documented here at <a href="http://dev.blockcypher.com/#generate-address-in-wallet-endpoint">docs</a>
//
// API used: GET /v1/btc/main/wallets/hd/Wallet-Name/addresses/generate

// In samples we are using CreateHDWallet.php sample to get the created instance of wallet.
// You have to run that sample before running this one or there will be no wallets

require __DIR__ . '/../bootstrap.php';

if (isset($_GET['wallet_name'])) {
    $walletName = filter_input(INPUT_GET, 'wallet_name', FILTER_SANITIZE_SPECIAL_CHARS);
} else {
    $walletName = 'bob'; // Default hd wallet name for samples
}

try {
    /// Get Wallet
    $wallet = \BlockCypher\Api\HDWallet::get($walletName, array(), $apiContexts['BTC.main']);

    /// Generate new address with subchain_index
    $params = array(
        'subchain_index' => 1,
    );
    $output = $wallet->generateAddress($params, $apiContexts['BTC.main']);
} catch (Exception $ex) {
    ResultPrinter::printError("Generate Address in a HDWallet", "HDWalletGenerateAddressResponse", $walletName, null, $ex);
    exit(1);
}

ResultPrinter::printResult("Generate Address in a HDWallet", "HDWalletGenerateAddressResponse", $walletName, null, $output);

return $output;
