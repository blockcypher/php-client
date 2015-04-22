<?php

// # Get Multiple Addresses Sample
// This method allows you to
// retrieve details about multiple addresses at once.
// API called: '/v1/btc/main/addrs/1J38WorKqMin9g5jqUfngZLJvA7TQUBZNE;1JP8F...'

require __DIR__ . '/../bootstrap.php';

// The following code takes you through
// the process of retrieving details about multiple Addresses at once.

/// ### Retrieve Multiple Addresses
// (See bootstrap.php for more on `ApiContext`)
try {

    // List of addresses. You can use height or hash and mix them in the same request
    $addressList = Array(
        '1J38WorKngZLJvA7qMin9g5jqUfTQUBZNE',
        '1JP8FqoXtCMrR1sZc2McLWmHxENox1Y1PV',
        '1ENn7XmqXNnReiQEFHhBGzfiv5gAyBj7r1'
    );

    $addresses = \BlockCypher\Api\Address::getMultiple($addressList, array(), $apiContext);
} catch (Exception $ex) {
    ResultPrinter::printError("Get Multiple Addresses", "Addresses", implode(",", $addressList), null, $ex);
    exit(1);
}

ResultPrinter::printResult("Get Multiple Addresses", "Addresses", implode(",", $addressList), null, $addresses);

return $addresses;