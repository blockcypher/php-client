<?php

// # Delete All PaymentForwards Sample
// This is a sample helper method, to delete all existing PaymentForwards.
// To properly use the sample, change the token from bootstrap.php file with your own app token.

// ## Get All PaymentForwards
$paymentForwardList = require 'ListPaymentForwards.php';

try {
    $paymentForwardIdList = array();
    /** @var \BlockCypher\Api\PaymentForward $paymentForward */
    foreach ($paymentForwardList as $paymentForward) {
        $paymentForwardIdList[] = $paymentForward->getId();
        // ### Delete PaymentForwards
        $paymentForward->delete($apiContexts['BTC.main']);
    }
} catch (Exception $ex) {
    ResultPrinter::printError("Delete All PaymentForwards", "", implode(';', $paymentForwardIdList), null, $ex);
    exit(1);
}

ResultPrinter::printResult("Delete All PaymentForwards", "", implode(';', $paymentForwardIdList), null, null);

return $output;