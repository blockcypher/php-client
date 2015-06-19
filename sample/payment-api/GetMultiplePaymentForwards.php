<?php

// # Get Multiple PaymentForwards Sample
//
// This sample code demonstrate how you can get multiple PaymentForwards at once
// API used: GET /v1/btc/main/payments/PaymentForward-Id;PaymentForward-Id

// ## Get PaymentForward ID.
// In samples we are using CreatePaymentForward.php sample to get the created instance of PaymentForward.
// However, in real case scenario, we could use just the ID.
/** @var \BlockCypher\Api\PaymentForward $paymentForward */
$paymentForward = require 'CreatePaymentForward.php';
$paymentForwardId = $paymentForward->getId();

try {
    // ### Get Multiple PaymentForwards
    $paymentForwardList = array($paymentForwardId, $paymentForwardId);

    $output = \BlockCypher\Api\PaymentForward::getMultiple($paymentForwardList, array(), $apiContexts['BTC.main']);
} catch (Exception $ex) {
    ResultPrinter::printError("Get Multiple PaymentForwards", "PaymentForward[]", null, implode(';', $paymentForwardList), $ex);
    exit(1);
}

ResultPrinter::printResult("Get Multiple PaymentForwards", "PaymentForward[]", implode(';', $paymentForwardList), null, $output);

return $output;