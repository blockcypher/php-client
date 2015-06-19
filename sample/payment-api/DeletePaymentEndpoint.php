<?php

// Run on console:
// php -f .\sample\payment-api\DeletePaymentEndpoint.php

require __DIR__ . '/../bootstrap.php';

use BlockCypher\Api\PaymentForward;
use BlockCypher\Auth\SimpleTokenCredential;
use BlockCypher\Rest\ApiContext;

$apiContext = ApiContext::create(
    'main', 'btc', 'v1',
    new SimpleTokenCredential('c0afcccdde5081d6429de37d16166ead'),
    array('log.LogEnabled' => true, 'log.FileName' => 'BlockCypher.log', 'log.LogLevel' => 'DEBUG')
);

$webHook = new PaymentForward();
$webHook->setId('ec2b4b4f-eeb2-4824-b528-7d78a6f52492');
$webHook->delete($apiContext);

ResultPrinter::printResult("Delete Payment Endpoint", "PaymentForward", 'ec2b4b4f-eeb2-4824-b528-7d78a6f52492', null, null);