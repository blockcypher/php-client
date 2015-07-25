<?php

// # List All PaymentForwards
// Use this call to list all the PaymentForwards, as documented here at:
// <a href="http://dev.blockcypher.com/#list-payments-endpoint">List Payments Endpoint</a>
//
// API used: GET /v1/btc/main/payments?token=<Your-Token>

// ## Create one PaymentForward
// This step is not necessarily required. We are creating a PaymentForward for sample purpose only,
// so that we would not get an empty list at any point.
// In real case, you do not need to create any PaymentForward to make this API call.
/** @var \BlockCypher\Api\PaymentForward $paymentForward */
$paymentForward = require 'CreateForwardingAddress.php';

$paymentForwardClient = new \BlockCypher\Client\PaymentForwardClient($apiContexts['BTC.main']);

try {
    $output = $paymentForwardClient->listForwardingAddresses();
} catch (Exception $ex) {
    ResultPrinter::printError("List Forwarding Addresses", "PaymentForward[]", null, null, $ex);
    exit(1);
}

ResultPrinter::printResult("List Forwarding Addresses", "PaymentForward[]", null, null, $output);

return $output;
