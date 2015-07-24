<?php

// # Get WebHook
// This sample code demonstrate how you can get a webhook, as documented here at:
// <a href="http://dev.blockcypher.com/#webhooks">Using webhooks</a>
//
// API used: GET /v1/btc/main/hooks/WebHook-Id

// ## Create Sample WebHook
// In samples we are using CreateWebHook.php sample to get the created instance of webhook.
// However, in real case scenario, we could use just the ID.
/** @var \BlockCypher\Api\WebHook $webHook */
$webHook = require 'CreateWebHook.php';
$webHookId = $webHook->getId();

$webHookClient = new \BlockCypher\Client\WebHookClient($apiContexts['BTC.main']);

// ## Get WebHook by Id
try {
    /// Get WebHook by Id
    $output = $webHookClient->get($webHookId);
} catch (Exception $ex) {
    ResultPrinter::printError("Get a WebHook", "WebHook", null, $webHookId, $ex);
    exit(1);
}

ResultPrinter::printResult("Get a WebHook", "WebHook", $output->getId(), null, $output);

return $output;
