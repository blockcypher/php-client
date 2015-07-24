<?php

// # Get HDWallet as Address
// The Address endpoint allows you to retrieve details about a HDWallet as Address.
//
// API called: '/v1/btc/main/addrs/HDWallet-Name'

require __DIR__ . '/../bootstrap.php';

if (isset($_GET['wallet_name'])) {
    $walletName = filter_input(INPUT_GET, 'wallet_name', FILTER_SANITIZE_SPECIAL_CHARS);
} else {
    $walletName = 'bob'; // Default hd wallet name for samples
}

$addressClient = new \BlockCypher\Client\AddressClient($apiContexts['BTC.main']);

try {
    $address = $addressClient->get($walletName);
} catch (Exception $ex) {
    ResultPrinter::printError("Get HDWallet Address", "Address", $walletName, null, $ex);
    exit(1);
}

ResultPrinter::printResult("Get HDWallet Address", "Address", $address->getAddress(), null, $address);

return $address;