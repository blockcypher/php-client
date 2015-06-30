<?php

// Run on console:
// php -f .\sample\payment-api\CreatePaymentEndpoint.php

require __DIR__ . '/../bootstrap.php';

use BlockCypher\Api\PaymentForward;
use BlockCypher\Auth\SimpleTokenCredential;
use BlockCypher\Rest\ApiContext;

$apiContext = ApiContext::create(
    'main', 'btc', 'v1',
    new SimpleTokenCredential('c0afcccdde5081d6429de37d16166ead'),
    array('mode' => 'sandbox', 'log.LogEnabled' => true, 'log.FileName' => 'BlockCypher.log', 'log.LogLevel' => 'DEBUG')
);

$paymentForward = new PaymentForward();
$paymentForward->setDestination('15qx9ug952GWGTNn7Uiv6vode4RcGrRemh');
$paymentForward->setCallbackUrl("http://requestb.in/rwp6jirw?uniqid=" . uniqid());

// For Sample Purposes Only.
$request = clone $paymentForward;

$paymentForward->create($apiContext);

ResultPrinter::printResult("Create Payment Endpoint", "PaymentForward", $paymentForward->getId(), $request, $paymentForward);