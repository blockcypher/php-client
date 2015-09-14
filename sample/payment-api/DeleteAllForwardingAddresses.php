<?php

// # Delete All PaymentForwards
// This is a sample helper method, to delete all existing PaymentForwards.
// To properly use the sample, change the token from bootstrap.php file with your own app token.

// ## Get All PaymentForwards
// We use ListPaymentForwards sample to get a PaymentForward list.
/** @var \BlockCypher\Api\PaymentForward[] $paymentForwardList */
$paymentForwardList = require 'ListForwardingAddresses.php';

$paymentForwardClient = new \BlockCypher\Client\PaymentForwardClient($apiContexts['BTC.main']);

// ## Delete All PaymentForwards
try {
    $paymentForwardIdList = array();
    /** @var \BlockCypher\Api\PaymentForward $paymentForward */
    foreach ($paymentForwardList as $paymentForward) {
        /// Only for Sample Purposes. List of deleted resources
        $paymentForwardIdList[] = $paymentForward->getId();
        /// Delete PaymentForward
        $paymentForwardClient->deleteForwardingAddress($paymentForward->getId());
    }
} catch (Exception $ex) {
    ResultPrinter::printError("Delete All PaymentForwards", "", implode(';', $paymentForwardIdList), null, $ex);
    exit(1);
}

ResultPrinter::printResult("Delete All PaymentForwards", "", implode(';', $paymentForwardIdList), null, null);