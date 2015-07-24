<?php

// # Get Wallet as Address
// The Address endpoint allows you to retrieve details about an Address or Wallet.
//
// API called: '/v1/btc/main/addrs/alice'

require __DIR__ . '/../bootstrap.php';

if (isset($_GET['wallet_name'])) {
    $walletName = filter_input(INPUT_GET, 'wallet_name', FILTER_SANITIZE_SPECIAL_CHARS);
} else {
    $walletName = 'alice'; // Default wallet name for samples
}

$addressClient = new \BlockCypher\Client\AddressClient($apiContexts['BTC.main']);

try {
    $address = $addressClient->get($walletName);
} catch (Exception $ex) {
    ResultPrinter::printError("Get Address", "Wallet as Address", $walletName, null, $ex);
    exit(1);
}

ResultPrinter::printResult("Get Address", "Wallet as Address", $address->getAddress(), null, $address);

return $address;