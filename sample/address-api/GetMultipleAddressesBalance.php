<?php

// # Get Multiple Addresses Balance
// This method allows you to retrieve balance of multiple addresses at once.
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
    /// List of addresses
    $addressList = array(
        '1J38WorKngZLJvA7qMin9g5jqUfTQUBZNE',
        '1JP8FqoXtCMrR1sZc2McLWmHxENox1Y1PV',
        '1ENn7XmqXNnReiQEFHhBGzfiv5gAyBj7r1'
    );

    $addressesBalance = $addressClient->getMultipleBalances($addressList);
} catch (Exception $ex) {
    ResultPrinter::printError("Get Multiple Addresses Balance", "Addresses Balance", implode(",", $addressList), null, $ex);
    exit(1);
}

ResultPrinter::printResult("Get Multiple Addresses Balance", "Addresses Balance", implode(",", $addressList), null, $addressesBalance);

return $addressesBalance;