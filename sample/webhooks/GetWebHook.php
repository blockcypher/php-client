<?php

// # Get WebHook Sample
//
// This sample code demonstrate how you can get a webhook, as documented here at:
// http://dev.blockcypher.com/#webhooks
// API used: GET /v1/btc/main/hooks/WebHook-Id

// ## Get WebHook ID.
// In samples we are using CreateWebHook.php sample to get the created instance of webhook.
// However, in real case scenario, we could use just the ID.
/** @var \BlockCypher\Api\WebHook $webHook */
$webHook = require 'CreateWebHook.php';
$webHookId = $webHook->getId();

// ### Get WebHook
try {
    $output = \BlockCypher\Api\WebHook::get($webHookId, array(), $apiContext);
} catch (Exception $ex) {
    ResultPrinter::printError("Get a WebHook", "WebHook", null, $webHookId, $ex);
    exit(1);
}

ResultPrinter::printResult("Get a WebHook", "WebHook", $output->getId(), null, $output);

return $output;
