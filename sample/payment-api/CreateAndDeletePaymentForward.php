<?php

// # Delete PaymentForward
// This sample code demonstrate how to use this call to delete a PaymentForward, as documented here at:
// <a href="http://dev.blockcypher.com/#delete-payment-endpoint">Delete Payment Endpoint</a>
//
// API used: DELETE /v1/btc/main/payments/PaymentForward-Id

// ## Create PaymentForward Instance
// This step is not necessarily required. We are creating a PaymentForward for sample purpose only,
// so that we would not get an empty list at any point.
// In real case, you do not need to create any PaymentForward to make this API call.
/** @var \BlockCypher\Api\PaymentForward $paymentForward */
$paymentForward = require 'CreatePaymentForward.php';

$paymentForwardClient = new \BlockCypher\Client\PaymentForwardClient($apiContexts['BTC.main']);

try {
    $output = $paymentForwardClient->delete($paymentForward->getId());
} catch (Exception $ex) {
    ResultPrinter::printError("Delete a PaymentForward", "PaymentForward", null, $paymentForward->getId(), $ex);
    exit(1);
}

ResultPrinter::printResult("Delete a PaymentForward", "PaymentForward", $paymentForward->getId(), null, null);

return $output;
