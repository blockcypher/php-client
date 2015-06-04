<?php

// # Get Wallet as Address Sample
// The Address resource allows you to
// retrieve details about an Address adn Wallets.
// API called: '/v1/btc/main/addrs/alice'

require __DIR__ . '/../bootstrap.php';

// The following code takes you through
// the process of retrieving details about this wallet 'alice'

// Wallet must be created
if (isset($_GET['wallet_name'])) {
    $walletName = filter_input(INPUT_GET, 'wallet_name', FILTER_SANITIZE_SPECIAL_CHARS);
} else {
    $walletName = 'alice'; // Default wallet name for samples
}

/// ### Retrieve alice wallet
// (See bootstrap.php for more on `ApiContext`)
try {
    $address = \BlockCypher\Api\Address::get($walletName, array(), $apiContexts['BTC.main']);
} catch (Exception $ex) {
    ResultPrinter::printError("Get Address", "Wallet as Address", $walletName, null, $ex);
    exit(1);
}

ResultPrinter::printResult("Get Address", "Wallet as Address", $address->getAddress(), null, $address);

return $address;