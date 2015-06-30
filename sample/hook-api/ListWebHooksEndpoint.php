<?php

// Run on console:
// php -f .\sample\hook-api\ListWebHooksEndpoint.php

require __DIR__ . '/../bootstrap.php';

use BlockCypher\Api\WebHook;
use BlockCypher\Auth\SimpleTokenCredential;
use BlockCypher\Rest\ApiContext;

$apiContext = ApiContext::create(
    'main', 'btc', 'v1',
    new SimpleTokenCredential('c0afcccdde5081d6429de37d16166ead'),
    array('mode' => 'sandbox', 'log.LogEnabled' => true, 'log.FileName' => 'BlockCypher.log', 'log.LogLevel' => 'DEBUG')
);

$webHooks = WebHook::getAll(array(), $apiContext);

ResultPrinter::printResult("List WebHooks Endpoint", "Array of WebHook", null, null, $webHooks);