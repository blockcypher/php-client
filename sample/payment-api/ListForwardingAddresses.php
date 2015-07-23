<?php

// # List All PaymentForwards
// Use this call to list all the PaymentForwards, as documented here at:
// <a href="http://dev.blockcypher.com/#list-payments-endpoint">List Payments Endpoint</a>
//
// API used: GET /v1/btc/main/payments?token=<Your-Token>

require __DIR__ . '/../bootstrap.php';

$paymentForwardClient = new \BlockCypher\Client\PaymentForwardClient($apiContexts['BTC.main']);

try {
    /// Get List of All PaymentForwards
    $output = $paymentForwardClient->listForwardingAddresses();
} catch (Exception $ex) {
    ResultPrinter::printError("List all Forwarding Addresses", "PaymentForward[]", null, null, $ex);
    exit(1);
}

ResultPrinter::printResult("List all Forwarding Addresses", "PaymentForward[]", null, null, $output);

return $output;
