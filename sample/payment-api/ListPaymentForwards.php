<?php

// # Get All PaymentForwards Sample
//
// Use this call to list all the PaymentForwards, as documented here at:
// <a href="http://dev.blockcypher.com/#list-payments-endpoint">http://dev.blockcypher.com/#list-payments-endpoint</a>
// API used: GET /v1/btc/main/payments?token=<Your-Token>

require __DIR__ . '/../bootstrap.php';

// ### Get List of All PaymentForwards
try {
    $output = \BlockCypher\Api\PaymentForward::getAll(array(), $apiContexts['BTC.main']);
} catch (Exception $ex) {
    ResultPrinter::printError("List all PaymentForwards", "PaymentForward[]", null, null, $ex);
    exit(1);
}

ResultPrinter::printResult("List all PaymentForwards", "PaymentForward[]", null, null, $output);

return $output;
