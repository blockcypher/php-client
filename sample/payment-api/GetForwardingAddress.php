<?php

// # Get PaymentForward
//
// This sample code demonstrate how you can get a PaymentForward, as documented here at:
// <a href="http://dev.blockcypher.com/#list-payments-endpoint">http://dev.blockcypher.com/#list-payments-endpoint</a>
//
// API used: GET /v1/btc/main/payments/PaymentForward-Id

// ## Get PaymentForward ID
// In samples we are using CreateForwardingAddress.php sample to get the created instance of PaymentForward.
// However, in real case scenario, we could use just the ID.
/** @var \BlockCypher\Api\PaymentForward $paymentForward */
$paymentForward = require 'CreateForwardingAddress.php';
$paymentForwardId = $paymentForward->getId();

$paymentForwardClient = new \BlockCypher\Client\PaymentForwardClient($apiContexts['BTC.main']);

try {
    /// Get PaymentForward
    $output = $paymentForwardClient->getForwardingAddress($paymentForwardId);
} catch (Exception $ex) {
    ResultPrinter::printError("Get Forwarding Address", "PaymentForward", null, $paymentForwardId, $ex);
    exit(1);
}

ResultPrinter::printResult("Get Forwarding Address", "PaymentForward", $output->getId(), null, $output);

return $output;
