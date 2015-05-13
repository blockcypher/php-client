<?php

// Include the composer autoloader
$loader = require dirname(__DIR__) . '/vendor/autoload.php';

$loader->add('BlockCypher\\Test', __DIR__);
$loader->add('sample\\Test', __DIR__);

if (!defined("BC_CONFIG_PATH")) {
    define("BC_CONFIG_PATH", __DIR__);
}

ini_set('precision', 17);
ini_set('serialize_precision', 17);
