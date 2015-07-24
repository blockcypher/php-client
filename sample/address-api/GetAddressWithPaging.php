<?php

// # Get Address Paging Transactions
// This method allows you to retrieve details about an Address only with some transactions.
//
// API called: '/v1/btc/main/addrs/1DEP8i3QJCsomS4BSMY2RpU1upv62aGvhD?before=300000'

require __DIR__ . '/../bootstrap.php';

// ## Params:
//
// before: Filters response to only include transactions below before height in the blockchain.
//
// limit: Only includes limit number of TXRefs; if unset, default is 50, while the maximum is 200.

/// override default sample address with GET parameter
if (isset($_GET['address'])) {
    $sampleAddress = filter_input(INPUT_GET, 'address', FILTER_SANITIZE_SPECIAL_CHARS);
} else {
    $sampleAddress = '1DEP8i3QJCsomS4BSMY2RpU1upv62aGvhD';
}

$addressClient = new \BlockCypher\Client\AddressClient($apiContexts['BTC.main']);

try {
    $params = array(
        'before' => 300000,
    );

    $address = $addressClient->get($sampleAddress, $params);
} catch (Exception $ex) {
    ResultPrinter::printError("Get Address", "Address", $sampleAddress, null, $ex);
    exit(1);
}

ResultPrinter::printResult("Get Address", "Address", $address->getAddress(), null, $address);

return $address;