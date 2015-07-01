<?php

// # List All WebHooks
// Use this call to list all the webhooks, as documented here at:
// <a href="http://dev.blockcypher.com/#webhooks">Using webhooks</a>
//
// API used: GET /v1/btc/main/hooks?token=<Your-Token>

// ## Create Sample WebHook
// This step is not necessarily required. We are creating a webhook for sample purpose only, so that we would not
// get an empty list at any point.
// In real case, you do not need to create any webhook to make this API call.
/** @var \BlockCypher\Api\WebHook $webHook */
$webHook = require 'CreateWebHook.php';

// ## Get all webhooks
try {
    $output = \BlockCypher\Api\WebHook::getAll(array(), $apiContexts['BTC.main']);
} catch (Exception $ex) {
    ResultPrinter::printError("List all WebHooks", "Array of WebHook", null, null, $ex);
    exit(1);
}

ResultPrinter::printResult("List all WebHooks", "Array of WebHook", null, null, $output);

return $output;
