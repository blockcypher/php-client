<?php

// # Get Address paging transactions Sample
// This method allows you to
// retrieve details about an Address only with some transactions.
// API called: '/v1/btc/main/addrs/1DEP8i3QJCsomS4BSMY2RpU1upv62aGvhD?before=300000'

require __DIR__ . '/../bootstrap.php';

// The following code takes you through
// the process of retrieving details about this address 1DEP8i3QJCsomS4BSMY2RpU1upv62aGvhD
// Transactions should be older than before URL parameter (block height)

/// ### Retrieve 1DEP8i3QJCsomS4BSMY2RpU1upv62aGvhD
// (See bootstrap.php for more on `ApiContext`)
try {

    $params = array(
        'before' => 300000,
    );

    $address = \BlockCypher\Api\Address::get('1DEP8i3QJCsomS4BSMY2RpU1upv62aGvhD', $params, $apiContext);
} catch (Exception $ex) {
    ResultPrinter::printError("Get Address", "Address", '1DEP8i3QJCsomS4BSMY2RpU1upv62aGvhD', null, $ex);
    exit(1);
}

ResultPrinter::printResult("Get Address", "Address", $address->getAddress(), null, $address);

return $address;