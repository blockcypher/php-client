<?php

// # Sign hex data with a private key
//
// This sample code demonstrate how you can use the signer included in this library to sign hex data with a
// private key. Private key mus be in the same format as returned by Generate Address Endpoint:
// <a href="http://dev.blockcypher.com/?shell#generate-address-endpoint">http://dev.blockcypher.com/?shell#generate-address-endpoint</a>

require __DIR__ . '/../bootstrap.php';

if (isset($_GET['tosign'])) {
    $tosign = filter_input(INPUT_GET, 'tosign', FILTER_SANITIZE_SPECIAL_CHARS);
} else {
    $tosign = "ed04813b11a47726c3b132a8ec5f067df8390058c463cd14e1e7216ba2f68b08"; // Default sample value
}

if (isset($_GET['private_key'])) {
    $privateKey = filter_input(INPUT_GET, 'private_key', FILTER_SANITIZE_SPECIAL_CHARS);
} else {
    $privateKey = "1551558c3b75f46b71ec068f9e341bf35ee6df361f7b805deb487d8a4d5f055e"; // Default sample value
}

try {
    $signature = BlockCypher\Crypto\Signer::sign($tosign, $privateKey);
} catch (Exception $ex) {
    ResultPrinter::printError("Sign", "toSign", null, json_encode($tosign), $ex);
    exit(1);
}

ResultPrinter::printResult("Sign", "toSign", null, json_encode($tosign), json_encode($signature));