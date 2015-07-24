<?php

// # Get UTXOs
// Get only unspent transaction outputs.
// This method allows you to retrieve details about an Address only with the unspent transactions.
//
// API called: '/v1/btc/main/addrs/1DEP8i3QJC...62aGvhD?unspentOnly=true'

require __DIR__ . '/../bootstrap.php';

/// override default sample address with GET parameter
if (isset($_GET['address'])) {
    $sampleAddress = filter_input(INPUT_GET, 'address', FILTER_SANITIZE_SPECIAL_CHARS);
} else {
    $sampleAddress = '1DEP8i3QJCsomS4BSMY2RpU1upv62aGvhD'; // Default address for samples
}

$addressClient = new \BlockCypher\Client\AddressClient($apiContexts['BTC.main']);

try {
    $params = array(
        'unspentOnly' => 'true', // NOTICE: string type not boolean
    );

    $address = $addressClient->get($sampleAddress, $params);
} catch (Exception $ex) {
    ResultPrinter::printError("Get Address", "Address", $sampleAddress, null, $ex);
    exit(1);
}

ResultPrinter::printResult("Get Address", "Address", $address->getAddress(), null, $address);

return $address;