<?php

// Run on console:
// php -f .\sample\hook-api\CreateWebHookEndpoint.php

require __DIR__ . '/../bootstrap.php';

use BlockCypher\Api\WebHook;
use BlockCypher\Auth\SimpleTokenCredential;
use BlockCypher\Rest\ApiContext;

$apiContext = ApiContext::create(
    'main', 'btc', 'v1',
    new SimpleTokenCredential('c0afcccdde5081d6429de37d16166ead'),
    array('mode' => 'sandbox', 'log.LogEnabled' => true, 'log.FileName' => 'BlockCypher.log', 'log.LogLevel' => 'DEBUG')
);

$webHook = new WebHook();
$webHook->setUrl("http://requestb.in/rwp6jirw?uniqid=" . uniqid());
$webHook->setEvent('unconfirmed-tx');
$webHook->setHash('2b17f5589528f97436b5d563635b4b27ca8980aa20c300abdc538f2a8bfa871b');

// For Sample Purposes Only.
$request = clone $webHook;

$webHookClient = new \BlockCypher\Client\WebHookClient($apiContext);
$webHook = $webHookClient->create($webHook);

ResultPrinter::printResult("Created WebHook Endpoint", "WebHook", $output->getId(), $request, $webHook);