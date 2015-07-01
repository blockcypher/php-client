<?php

// # Sign Hex Data
// This sample code demonstrate how you can use the signer included in this library to sign hex data with a
// private key. Private key mus be in the same format as returned by:
// <a href="http://dev.blockcypher.com/?shell#generate-address-endpoint">Generate Address Endpoint</a>

require __DIR__ . '/../bootstrap.php';

// ## Sample accepts GET parameters
// You can add 'tosign' as GET parameter in this sample url to override data to sign.
// You can add 'private_key' as GET parameter in this sample url to override private key used.
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

// ## Using signer
// Signer uses 'Deterministic Signatures' which means you will always get the same signature with the same input.
try {
    $signature = BlockCypher\Crypto\Signer::sign($tosign, $privateKey);
} catch (Exception $ex) {
    ResultPrinter::printError("Sign", "toSign", null, json_encode($tosign), $ex);
    exit(1);
}

ResultPrinter::printResult("Sign", "toSign", null, json_encode($tosign), json_encode($signature));

// ## Run on console
// SDK includes in root folder a signer command.
//
// signer {tosign} {private_key}
//
// Windows
//
//     C:\> .\signer ed04813b11a47726c3b132a8ec5f067df8390058c463cd14e1e7216ba2f68b08 1551558c3b75f46b71ec068f9e341bf35ee6df361f7b805deb487d8a4d5f055e
//     304402202b1088e5a66db93dca8ad1977f2544227ad9a740c5aed78da7d07b56b7b31f5802207af55b3ed791f350e4b48d2a334db004e930767bdccbf05face1bb8a5135fc91
// Linux
//
//     $ ./signer ed04813b11a47726c3b132a8ec5f067df8390058c463cd14e1e7216ba2f68b08 1551558c3b75f46b71ec068f9e341bf35ee6df361f7b805deb487d8a4d5f055e
//     304402202b1088e5a66db93dca8ad1977f2544227ad9a740c5aed78da7d07b56b7b31f5802207af55b3ed791f350e4b48d2a334db004e930767bdccbf05face1bb8a5135fc91