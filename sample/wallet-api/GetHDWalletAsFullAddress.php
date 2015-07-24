<?php

// # Get Full HDWallet
// This method allows you to retrieve all details about a given wallet, including full transaction information.
//
// API called: '/v1/btc/main/addrs/HDWallet-Name/full'

require __DIR__ . '/../bootstrap.php';

if (isset($_GET['wallet_name'])) {
    $walletName = filter_input(INPUT_GET, 'wallet_name', FILTER_SANITIZE_SPECIAL_CHARS);
} else {
    $walletName = 'bob'; // Default hd wallet name for samples
}

$addressClient = new \BlockCypher\Client\AddressClient($apiContexts['BTC.main']);

try {
    $fullAddress = $addressClient->getFullAddress($walletName);
} catch (Exception $ex) {
    ResultPrinter::printError("Get HDWallet as FullAddress", "FullAddress", $walletName, null, $ex);
    exit(1);
}

ResultPrinter::printResult("Get HDWallet as FullAddress", "FullAddress", $fullAddress->getAddress(), null, $fullAddress);

return $fullAddress;