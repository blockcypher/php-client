<?php

// # Get All WebHooks Sample
//
// Use this call to list all the webhooks, as documented here at:
// http://dev.blockcypher.com/#webhooks
// API used: GET /v1/btc/main/hooks?token=<Your-Token>

// ## List WebHooks

// This step is not necessarily required. We are creating a webhook for sample purpose only, so that we would not
// get an empty list at any point.
// In real case, you do not need to create any webhook to make this API call.
/** @var \BlockCypher\Api\WebHook $webHook */
$webHook = require 'CreateWebHook.php';

// ### Get List of All WebHooks
try {
    $output = \BlockCypher\Api\WebHook::getAll(array(), $apiContext);
} catch (Exception $ex) {
    ResultPrinter::printError("List all WebHooks", "WebHookList", null, null, $ex);
    exit(1);
}

ResultPrinter::printResult("List all WebHooks", "WebHookList", null, null, $output);

return $output;
