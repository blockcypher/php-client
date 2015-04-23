<?php

// # Delete All WebHooks Sample
// This is a sample helper method, to delete all existing webhooks.
// To properly use the sample, change the token from bootstrap.php file with your own app token.

// ## Get WebHook Instance

$webHookList = require 'ListWebHooks.php';

// ### Delete All WebHooks
try {
    $webHookIdList = array();
    /** @var \BlockCypher\Api\WebHook $webHook */
    foreach ($webHookList as $webHook) {
        $webHookIdList[] = $webHook->getId();
        $webHook->delete($apiContext);
    }
} catch (Exception $ex) {
    ResultPrinter::printError("Deleted All WebHooks", "", implode(';', $webHookIdList), null, $ex);
    exit(1);
}

ResultPrinter::printResult("Delete All WebHook", "", implode(';', $webHookIdList), null, null);

return $output;