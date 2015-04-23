<?php

// # Get Multiple Full Addresses Sample
// This method allows you to
// retrieve multiple addresses at once with all details about each Address.
// API called: '/v1/btc/main/addrs/1J38...BZNE;1JP8...Y1PV;1ENn...j7r1/full'

require __DIR__ . '/../bootstrap.php';

// The following code takes you through
// the process of retrieving full address info of multiple addresses at once.

/// ### Retrieve Multiple Full Addresses
// (See bootstrap.php for more on `ApiContext`)
try {

    // List of addresses. You can use height or hash and mix them in the same request
    $addressList = Array(
        '1J38WorKngZLJvA7qMin9g5jqUfTQUBZNE',
        '1JP8FqoXtCMrR1sZc2McLWmHxENox1Y1PV',
        '1ENn7XmqXNnReiQEFHhBGzfiv5gAyBj7r1'
    );

    $fullAddresses = \BlockCypher\Api\FullAddress::getMultiple($addressList, array(), $apiContext);
} catch (Exception $ex) {
    ResultPrinter::printError("Get Multiple Full Addresses", "Full Addresses", implode(",", $addressList), null, $ex);
    exit(1);
}

ResultPrinter::printResult("Get Multiple Full Addresses", "Full Addresses", implode(",", $addressList), null, $fullAddresses);

return $fullAddresses;