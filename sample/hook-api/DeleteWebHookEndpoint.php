<?php

// Run on console:
// php -f .\sample\hook-api\DeleteWebHookEndpoint.php

require __DIR__ . '/../bootstrap.php';

use BlockCypher\Api\WebHook;
use BlockCypher\Auth\SimpleTokenCredential;
use BlockCypher\Rest\ApiContext;

$apiContext = ApiContext::create(
    'main', 'btc', 'v1',
    new SimpleTokenCredential('c0afcccdde5081d6429de37d16166ead'),
    array('log.LogEnabled' => true, 'log.FileName' => 'BlockCypher.log', 'log.LogLevel' => 'DEBUG')
);

// Option 1: get the object before removing it
//$webHook = WebHook::get('d5ca3bd3-5dfb-477d-9fb4-ac3510af258d', array(), $apiContext);

// Option 2: create a new empty object only with its ID. You save one API request
$webHook = new WebHook();
$webHook->setId('d5ca3bd3-5dfb-477d-9fb4-ac3510af258d');

$webHook->delete($apiContext);

ResultPrinter::printResult("Delete WebHook Endpoint", "WebHook", 'd5ca3bd3-5dfb-477d-9fb4-ac3510af258d', null, $webHook);