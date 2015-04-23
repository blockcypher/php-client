<?php

// # Delete WebHook Sample
//
// This sample code demonstrate how to use this call to a WebHook, as documented here at:
// http://dev.blockcypher.com/#webhooks
// API used: DELETE /v1/btc/main/hooks/Webhook-Id

// ## Get WebHook Instance

/** @var \BlockCypher\Api\WebHook $webHook */
$webHook = require 'CreateWebHook.php';

// ### Delete WebHook
try {
    $output = $webHook->delete($apiContext);
} catch (Exception $ex) {
    ResultPrinter::printError("Delete a WebHook", "WebHook", null, $webHook->getId(), $ex);
    exit(1);
}

ResultPrinter::printResult("Delete a WebHook", "WebHook", $webHook->getId(), null, null);

return $output;
