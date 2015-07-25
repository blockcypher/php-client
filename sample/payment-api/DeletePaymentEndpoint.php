<?php

// Run on console:
// php -f .\sample\payment-api\DeletePaymentEndpoint.php

require __DIR__ . '/../bootstrap.php';

use BlockCypher\Auth\SimpleTokenCredential;
use BlockCypher\Client\PaymentForwardClient;
use BlockCypher\Rest\ApiContext;

$apiContext = ApiContext::create(
    'main', 'btc', 'v1',
    new SimpleTokenCredential('c0afcccdde5081d6429de37d16166ead'),
    array('mode' => 'sandbox', 'log.LogEnabled' => true, 'log.FileName' => 'BlockCypher.log', 'log.LogLevel' => 'DEBUG')
);

$paymentForwardClient = new PaymentForwardClient($apiContext);
$paymentForwardClient->deleteForwardingAddress('1fdf8f9b-cc37-4955-882b-8cbcd670a433');

ResultPrinter::printResult("Delete Payment Endpoint", "PaymentForward", '1fdf8f9b-cc37-4955-882b-8cbcd670a433', null, null);