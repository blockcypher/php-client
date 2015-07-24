<?php

// # Get Multiple WebHooks
// This sample code demonstrate how you can get multiple webhooks at once, as documented here at:
// <a href="http://dev.blockcypher.com/#webhooks">Using webhooks</a>
//
// API used: GET /v1/btc/main/hooks/WebHook-Id;WebHook-Id

// ## Create Sample WebHook
// In samples we are using CreateWebHook.php sample to get the created instance of webhook.
// However, in real case scenario, we could use just the ID.
/** @var \BlockCypher\Api\WebHook $webHook */
$webHook = require 'CreateWebHook.php';
$webHookId = $webHook->getId();

$webHookClient = new \BlockCypher\Client\WebHookClient($apiContexts['BTC.main']);

// ## Get Multiple WebHooks
try {
    $webHookList = array($webHookId);
    $output = $webHookClient->getMultiple($webHookList);
} catch (Exception $ex) {
    ResultPrinter::printError("Get Multiple WebHooks", "WebHook[]", null, implode(';', $webHookList), $ex);
    exit(1);
}

ResultPrinter::printResult("Get Multiple WebHooks", "WebHook[]", implode(';', $webHookList), null, $output);

return $output;