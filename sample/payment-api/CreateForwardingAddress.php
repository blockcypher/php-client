<?php

// # Create a Payment Forwarding Address
//
// This sample code demonstrate how you can create a payment forwarding address, as documented here at:
// <a href="http://dev.blockcypher.com/#create-payment-endpoint">Create Payment Endpoint</a>
//
// API used: POST /v1/btc/main/payments

require __DIR__ . '/../bootstrap.php';

$paymentForwardClient = new \BlockCypher\Client\PaymentForwardClient($apiContexts['BTC.main']);

$destination = '15qx9ug952GWGTNn7Uiv6vode4RcGrRemh';
$callbackUrl = 'http://requestb.in/rwp6jirw?uniqid=' . uniqid();

/// For Sample Purposes Only.
$paymentForward = new \BlockCypher\Api\PaymentForward();
$paymentForward->setDestination($destination);
$paymentForward->setCallbackUrl($callbackUrl);
$request = clone $paymentForward;

$options = array(
    'callback_url' => $callbackUrl
);

try {
    $output = $paymentForwardClient->createForwardingAddress($destination, $options);
} catch (Exception $ex) {
    ResultPrinter::printError("Create Forwarding Address", "PaymentForward", null, $request, $ex);
    exit(1);
}

ResultPrinter::printResult("Create Forwarding Address", "PaymentForward", $output->getId(), $request, $output);

return $output;