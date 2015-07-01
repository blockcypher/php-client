<?php

// # Get PaymentForward
//
// This sample code demonstrate how you can get a PaymentForward, as documented here at:
// <a href="http://dev.blockcypher.com/#list-payments-endpoint">http://dev.blockcypher.com/#list-payments-endpoint</a>
//
// API used: GET /v1/btc/main/payments/PaymentForward-Id

// ## Get PaymentForward ID
// In samples we are using CreatePaymentForward.php sample to get the created instance of PaymentForward.
// However, in real case scenario, we could use just the ID.
/** @var \BlockCypher\Api\PaymentForward $paymentForward */
$paymentForward = require 'CreatePaymentForward.php';
$paymentForwardId = $paymentForward->getId();

try {
    /// Get PaymentForward
    $output = \BlockCypher\Api\PaymentForward::get($paymentForwardId, array(), $apiContexts['BTC.main']);
} catch (Exception $ex) {
    ResultPrinter::printError("Get a PaymentForward", "PaymentForward", null, $paymentForwardId, $ex);
    exit(1);
}

ResultPrinter::printResult("Get a PaymentForward", "PaymentForward", $output->getId(), null, $output);

return $output;
