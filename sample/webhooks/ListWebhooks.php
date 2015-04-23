<?php

// # Get All WebHooks Sample
//
// Use this call to list all the webhooks, as documented here at:
// http://dev.blockcypher.com/#webhooks
// API used: GET /v1/btc/main/hooks?token=<Your-Token>

require __DIR__ . '/../bootstrap.php';

// ### Get List of All WebHooks
try {
    $output = \BlockCypher\Api\WebHook::getAll(array(), $apiContext);
} catch (Exception $ex) {
    ResultPrinter::printError("List all WebHooks", "WebHookList", null, null, $ex);
    exit(1);
}

ResultPrinter::printResult("List all WebHooks", "WebHookList", null, null, $output);

return $output;
