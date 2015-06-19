<?php

// # Create a Forward Payment Sample
//
// This sample code demonstrate how you can create a payment forward address, as documented here at:
// <a href="http://dev.blockcypher.com/?shell#create-payment-endpoint">http://dev.blockcypher.com/?shell#create-payment-endpoint</a>
// API used: POST /v1/btc/main/payments

require __DIR__ . '/../bootstrap.php';

$paymentForward = new \BlockCypher\Api\PaymentForward();
$paymentForward->setDestination('15qx9ug952GWGTNn7Uiv6vode4RcGrRemh');
$paymentForward->setCallbackUrl("http://requestb.in/rwp6jirw?uniqid=" . uniqid());

// For Sample Purposes Only.
$request = clone $paymentForward;

try {
    $output = $paymentForward->create($apiContexts['BTC.main']);
} catch (Exception $ex) {
    ResultPrinter::printError("Create PaymentForward", "PaymentForward", null, $request, $ex);
    exit(1);
}

ResultPrinter::printResult("Create PaymentForward", "PaymentForward", $output->getId(), $request, $output);

return $output;