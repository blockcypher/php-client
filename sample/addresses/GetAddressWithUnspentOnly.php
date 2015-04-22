<?php

// # Get Address Only with the unspent transactions Sample
// This method allows you to
// retrieve details about an Address only with the unspent transactions.
// API called: '/v1/btc/main/addrs/1DEP8i3QJCsomS4BSMY2RpU1upv62aGvhD?unspentOnly=true'

require __DIR__ . '/../bootstrap.php';

// The following code takes you through
// the process of retrieving details about this address 1DEP8i3QJCsomS4BSMY2RpU1upv62aGvhD
// only with the unspent transactions

/// ### Retrieve 1DEP8i3QJCsomS4BSMY2RpU1upv62aGvhD
// (See bootstrap.php for more on `ApiContext`)
try {

    $params = array(
        'unspentOnly' => 'true', // NOTICE: string type not boolean
    );

    $address = \BlockCypher\Api\Address::get('1DEP8i3QJCsomS4BSMY2RpU1upv62aGvhD', $params, $apiContext);
} catch (Exception $ex) {
    ResultPrinter::printError("Get Address", "Address", '1DEP8i3QJCsomS4BSMY2RpU1upv62aGvhD', null, $ex);
    exit(1);
}

ResultPrinter::printResult("Get Address", "Address", $address->getAddress(), null, $address);

return $address;