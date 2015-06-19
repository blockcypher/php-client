<?php

// # Delete PaymentForward Sample
//
// This sample code demonstrate how to use this call to delete a PaymentForward, as documented here at:
// <a href="http://dev.blockcypher.com/#delete-payment-endpoint">http://dev.blockcypher.com/#delete-payment-endpoint</a>
// API used: DELETE /v1/btc/main/payments/PaymentForward-Id

// ## Get PaymentForward Instance

/** @var \BlockCypher\Api\PaymentForward $paymentForward */
$paymentForward = require 'CreatePaymentForward.php';

try {
    // ### Delete PaymentForward
    $output = $paymentForward->delete($apiContexts['BTC.main']);
} catch (Exception $ex) {
    ResultPrinter::printError("Delete a PaymentForward", "PaymentForward", null, $paymentForward->getId(), $ex);
    exit(1);
}

ResultPrinter::printResult("Delete a PaymentForward", "PaymentForward", $paymentForward->getId(), null, null);

return $output;
