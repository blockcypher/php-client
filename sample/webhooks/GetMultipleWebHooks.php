<?php

// # Get Multiple WebHooks Sample
//
// This sample code demonstrate how you can get multiple webhooks at once, as documented here at:
// http://dev.blockcypher.com/#webhooks
// API used: GET /v1/btc/main/hooks/WebHook-Id;WebHook-Id

// ## Get WebHook ID.
// In samples we are using CreateWebHook.php sample to get the created instance of webhook.
// However, in real case scenario, we could use just the ID.
/** @var \BlockCypher\Api\WebHook $webHook */
$webHook = require 'CreateWebHook.php';
$webHookId = $webHook->getId();

// ### Get Multiple WebHooks
try {
    $webHookList = array($webHookId);

    $output = \BlockCypher\Api\WebHook::getMultiple($webHookList, array(), $apiContext);
} catch (Exception $ex) {
    ResultPrinter::printError("Get Multiple WebHooks", "WebHook Array", null, implode(';', $webHookList), $ex);
    exit(1);
}

ResultPrinter::printResult("Get Multiple WebHooks", "WebHook Array", implode(';', $webHookList), null, $output);

return $output;