<?php

// Run on console:
// php -f .\sample\payment-api\ListPaymentsEndpoint.php

require __DIR__ . '/../bootstrap.php';

use BlockCypher\Api\PaymentForward;
use BlockCypher\Auth\SimpleTokenCredential;
use BlockCypher\Rest\ApiContext;

$apiContext = ApiContext::create(
    'main', 'btc', 'v1',
    new SimpleTokenCredential('c0afcccdde5081d6429de37d16166ead'),
    array('log.LogEnabled' => true, 'log.FileName' => 'BlockCypher.log', 'log.LogLevel' => 'DEBUG')
);

$paymentForwardArray = PaymentForward::getAll(array(), $apiContext);

ResultPrinter::printResult("List all PaymentForwards", "PaymentForward[]", null, null, $paymentForwardArray);