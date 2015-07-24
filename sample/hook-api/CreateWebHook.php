<?php

// # Create WebHook
// This sample code demonstrate how you can create a webhook, as documented here at:
// <a href="http://dev.blockcypher.com/#using-webhooks">Using Webhooks</a>
//
// API used: POST /v1/btc/main/hooks

require __DIR__ . '/../bootstrap.php';

$webHook = new \BlockCypher\Api\WebHook();
$webHook->setUrl("http://requestb.in/rwp6jirw?uniqid=" . uniqid());
$webHook->setEvent('unconfirmed-tx');
$webHook->setHash('2b17f5589528f97436b5d563635b4b27ca8980aa20c300abdc538f2a8bfa871b');

/// For Sample Purposes Only.
$request = clone $webHook;

$webHookClient = new \BlockCypher\Client\WebHookClient($apiContexts['BTC.main']);

/// Create WebHook
try {
    $output = $webHookClient->create($webHook);
} catch (Exception $ex) {
    ResultPrinter::printError("Created WebHook", "WebHook", null, $request, $ex);
    exit(1);
}

ResultPrinter::printResult("Created WebHook", "WebHook", $output->getId(), $request, $output);

return $output;

// # WebHook request
//     {
//         "url":"https://requestb.in/slmm49sl",
//         "event":"unconfirmed-tx",
//         "hash":"2b17f5589528f97436b5d...8980aa20c300abdc538f2a8bfa871b",
//     }
// Fill up the basic information that is required for the webhook
// The URL should be actually accessible over the internet. Having a localhost here would not work.
// #### There is an open source tool http://requestb.in/ that allows you to receive any web requests to a url given there.
// #### NOTE: Please note that the use of https is recommended for webhooks.
// The transaction or block associated with the event you subscribed to will be POSTed to the provided URL.
// The POST request will also include a X-EventType and a X-EventId HTTP header specifying the type of and id
// of the webhook which triggered the request.
// X-Eventtype: unconfirmed-tx
// X-Eventid: f1cef7d6-cfd9-459c-8ebc-42226ae2b1a7

// # Event Types
// Event types correspond to what kind of notifications you want to receive on the given URL.
// Complete <a href="http://dev.blockcypher.com/#types-of-events">event list</a>.
