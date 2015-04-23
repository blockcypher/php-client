<?php

// # Create WebHook Sample
//
// This sample code demonstrate how you can create a webhook, as documented here at:
// <a href="http://dev.blockcypher.com/#webhooks">http://dev.blockcypher.com/#webhooks</a>
// API used: POST /v1/btc/main/hooks

require __DIR__ . '/../bootstrap.php';

// Create a new instance of WebHook object
$webhook = new \BlockCypher\Api\WebHook();

// # Basic Information
//     {
//         "event":"unconfirmed-tx",
//         "url":"https://requestb.in/slmm49sl",
//      }
// Fill up the basic information that is required for the webhook
// The URL should be actually accessible over the internet. Having a localhost here would not work.
// #### There is an open source tool http://requestb.in/ that allows you to receive any web requests to a url given there.
// #### NOTE: Please note that the use of https is recommended for webhooks.
// The transaction or block associated with the event you subscribed to will be POSTed to the provided URL.
// The POST request will also include a X-EventType and a X-EventId HTTP header specifying the type of and id
// of the webhook which triggered the request.
// X-Eventtype: unconfirmed-tx
// X-Eventid: f1cef7d6-cfd9-459c-8ebc-42226ae2b1a7
$webhook->setUrl("https://requestb.in/slmm49sl?uniqid=" . uniqid());

// # Event Types
// Event types correspond to what kind of notifications you want to receive on the given URL.
// Complete event list: <a href="http://dev.blockcypher.com/#events">http://dev.blockcypher.com/#events</a>
$webhook->setEvent('unconfirmed-tx');

// For Sample Purposes Only.
$request = clone $webhook;

// ### Create WebHook
try {
    $output = $webhook->create($apiContext);
} catch (Exception $ex) {
    ResultPrinter::printError("Created WebHook", "WebHook", null, $request, $ex);
    exit(1);
}

ResultPrinter::printResult("Created WebHook", "WebHook", $output->getId(), $request, $output);

return $output;
