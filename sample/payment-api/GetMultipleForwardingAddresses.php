<?php

// # Get Multiple PaymentForwards
// This sample code demonstrate how you can get multiple PaymentForwards at once.
//
// API used: GET /v1/btc/main/payments/PaymentForward-Id;PaymentForward-Id

// ## Get PaymentForward ID
// In samples we are using CreateForwardingAddress.php sample to get the created instance of PaymentForward.
// However, in real case scenario, we could use just the ID.
/** @var \BlockCypher\Api\PaymentForward $paymentForward */
$paymentForward = require 'CreateForwardingAddress.php';
$paymentForwardId01 = $paymentForward->getId();
$paymentForwardId02 = $paymentForward->getId();

$paymentForwardClient = new \BlockCypher\Client\PaymentForwardClient($apiContexts['BTC.main']);

try {
    /// Get Multiple Forwarding Addresses
    $paymentForwardList = array($paymentForwardId01, $paymentForwardId02);
    $output = $paymentForwardClient->getMultiple($paymentForwardList);
} catch (Exception $ex) {
    ResultPrinter::printError("Get Multiple Forwarding Addresses", "PaymentForward[]", null, implode(';', $paymentForwardList), $ex);
    exit(1);
}

ResultPrinter::printResult("Get Multiple Forwarding Addresses", "PaymentForward[]", implode(';', $paymentForwardList), null, $output);

return $output;