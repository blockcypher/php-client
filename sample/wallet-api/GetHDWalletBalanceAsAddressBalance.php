<?php

// # Get Only HDWallet Balance
// This method allows you to retrieve only balance and number of transactions for a given hd wallet.
//
// API called: '/v1/btc/main/addrs/HDWallet-Name/balance'

require __DIR__ . '/../bootstrap.php';

if (isset($_GET['wallet_name'])) {
    $walletName = filter_input(INPUT_GET, 'wallet_name', FILTER_SANITIZE_SPECIAL_CHARS);
} else {
    $walletName = 'bob'; // Default hd wallet name for samples
}

$addressClient = new \BlockCypher\Client\AddressClient($apiContexts['BTC.main']);

try {
    $addressBalance = $addressClient->getBalance($walletName);
} catch (Exception $ex) {
    ResultPrinter::printError("Get HDWallet as AddressBalance", "AddressBalance", $walletName, null, $ex);
    exit(1);
}

ResultPrinter::printResult("Get HDWallet as AddressBalance", "AddressBalance", $addressBalance->getAddress(), null, $addressBalance);

return $addressBalance;