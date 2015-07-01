<?php

// # Delete WebHook
// This sample code demonstrate how to use this call to a WebHook, as documented here at:
// <a href="http://dev.blockcypher.com/#webhooks">Using webhooks</a>
//
// API used: DELETE /v1/btc/main/hooks/Webhook-Id

// ## Create Sample WebHook
// This step is not necessarily required. We are creating a webhook for sample purpose only, so that we would not
// get an empty list at any point.
// In real case, you do not need to create any webhook to make this API call.
/** @var \BlockCypher\Api\WebHook $webHook */
$webHook = require 'CreateWebHook.php';

// ## Delete WebHook
try {
    $output = $webHook->delete($apiContexts['BTC.main']);
} catch (Exception $ex) {
    ResultPrinter::printError("Delete a WebHook", "WebHook", null, $webHook->getId(), $ex);
    exit(1);
}

ResultPrinter::printResult("Delete a WebHook", "WebHook", $webHook->getId(), null, null);

return $output;
