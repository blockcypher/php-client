<?php

require __DIR__ . '/artifacts/blockcypher.phar';

// Ensure that a ApiContext can be created.
$config = array(
    'mode' => 'sandbox',
    'log.LogEnabled' => true,
    'log.FileName' => '../BlockCypher.log',
    'log.LogLevel' => 'DEBUG', // PLEASE USE `INFO` LEVEL FOR LOGGING IN LIVE ENVIRONMENTS
    'validation.level' => 'log',
    // 'http.CURLOPT_CONNECTTIMEOUT' => 30
);
$credentials = new BlockCypher\Auth\SimpleTokenCredential($token);
$apiContext = BlockCypher\Rest\ApiContext::create(
    'main',
    'btc',
    'v1',
    $credentials,
    $config);

echo 'Version=' . \BlockCypher\Core\BlockCypherConstants::SDK_VERSION;
