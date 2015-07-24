<?php

// # Get Multiple Addresses
// This method allows you to retrieve details about multiple addresses at once.
//
// API called: '/v1/btc/main/addrs/1J38WorKqMin9g5jqUfngZLJvA7TQUBZNE;1JP8F...'

require __DIR__ . '/../bootstrap.php';

$addressClient = new \BlockCypher\Client\AddressClient($apiContexts['BTC.main']);

$addressList = array(
    '1J38WorKngZLJvA7qMin9g5jqUfTQUBZNE',
    '1JP8FqoXtCMrR1sZc2McLWmHxENox1Y1PV',
    '1ENn7XmqXNnReiQEFHhBGzfiv5gAyBj7r1'
);

try {
    $addresses = $addressClient->getMultiple($addressList);
} catch (Exception $ex) {
    ResultPrinter::printError("Get Multiple Addresses", "Addresses", implode(",", $addressList), null, $ex);
    exit(1);
}

ResultPrinter::printResult("Get Multiple Addresses", "Addresses", implode(",", $addressList), null, $addresses);

return $addresses;