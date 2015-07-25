<?php

// Run on console:
// php -f .\sample\payment-api\CreatePaymentEndpoint.php

require __DIR__ . '/../bootstrap.php';

use BlockCypher\Api\PaymentForward;
use BlockCypher\Auth\SimpleTokenCredential;
use BlockCypher\Client\PaymentForwardClient;
use BlockCypher\Rest\ApiContext;

$apiContext = ApiContext::create(
    'main', 'btc', 'v1',
    new SimpleTokenCredential('c0afcccdde5081d6429de37d16166ead'),
    array('mode' => 'sandbox', 'log.LogEnabled' => true, 'log.FileName' => 'BlockCypher.log', 'log.LogLevel' => 'DEBUG')
);

$paymentForwardClient = new PaymentForwardClient($apiContext);
$options = array(
    'callback_url' => 'http://requestb.in/rwp6jirw?uniqid=' . uniqid()
);
$paymentForward = $paymentForwardClient->createForwardingAddress('15qx9ug952GWGTNn7Uiv6vode4RcGrRemh', $options);

// For Sample Purposes Only.
$request = new PaymentForward();
$request->setDestination('15qx9ug952GWGTNn7Uiv6vode4RcGrRemh');
$request->setCallbackUrl('http://requestb.in/rwp6jirw?uniqid=' . uniqid());

ResultPrinter::printResult("Create Payment Endpoint", "PaymentForward", $paymentForward->getId(), $request, $paymentForward);