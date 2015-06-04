<?php

// # Get Address Sample
// The Address resource allows you to
// retrieve details about an Address.
// API called: '/v1/btc/main/addrs/1DEP8i3QJCsomS4BSMY2RpU1upv62aGvhD'

require __DIR__ . '/../bootstrap.php';

// The following code takes you through
// the process of retrieving details about this address 2N66DDrmjDCMM3yMSYtAQyAqRtasSkFhbmX

// override default sample address with GET parameter
if (isset($_GET['address'])) {
    $sampleAddress = filter_input(INPUT_GET, 'address', FILTER_SANITIZE_SPECIAL_CHARS);
} else {
    $sampleAddress = '2N66DDrmjDCMM3yMSYtAQyAqRtasSkFhbmX'; // Default address for samples
}

/// ### Retrieve 2N66DDrmjDCMM3yMSYtAQyAqRtasSkFhbmX
// (See bootstrap.php for more on `ApiContext`)
try {
    // BTC.test3 address
    $address = \BlockCypher\Api\Address::get($sampleAddress, array(), $apiContexts['BTC.test3']);
} catch (Exception $ex) {
    ResultPrinter::printError("Get Address BTC Test3", "Address", $sampleAddress, null, $ex);
    exit(1);
}

ResultPrinter::printResult("Get Address BTC Test3", "Address", $address->getAddress(), null, $address);

return $address;