<?php

/*
 * Sample bootstrap file.
 */

// Include the composer Autoloader
// The location of your project's vendor autoloader.
$composerAutoload = dirname(dirname(dirname(__DIR__))) . '/autoload.php';
if (!file_exists($composerAutoload)) {
    //If the project is used as its own project, it would use rest-api-sdk-php composer autoloader.
    $composerAutoload = dirname(__DIR__) . '/vendor/autoload.php';


    if (!file_exists($composerAutoload)) {
        echo "The 'vendor' folder is missing. You must run 'composer update' to resolve application dependencies.\nPlease see the README for more information.\n";
        exit(1);
    }
}

/** @noinspection PhpIncludeInspection */
require $composerAutoload;
require __DIR__ . '/common.php';

use BlockCypher\Auth\SimpleTokenCredential;
use BlockCypher\Core\BlockCypherCoinSymbolConstants;
use BlockCypher\Rest\ApiContext;
use BlockCypher\Validation\TokenValidator;

error_reporting(E_ALL);
ini_set('display_errors', '1');
if (ini_set('precision', 17) === false) {
    die("Couldn't update precision.");
}
if (ini_set('serialize_precision', 17) === false) {
    die("Couldn't update serialize_precision.");
}

// Replace these values by entering your own token by visiting https://accounts.blockcypher.com/
/** @noinspection SpellCheckingInspection */
$token = 'c0afcccdde5081d6429de37d16166ead';

if (isset($_GET['token'])) $token = $_GET['token'];
if (!validateToken($token)) {
    echo 'Invalid token. Please get new one: <a href="https://accounts.blockcypher.com/">https://accounts.blockcypher.com/</a>';
    exit(1);
}

/** @var \BlockCypher\Rest\ApiContext $apiContext */
$apiContextSdkConfigFile = getApiContextUsingConfigIni();

$apiContexts = createApiContextForAllChains($token);
$apiContexts['sdk_config'] = $apiContextSdkConfigFile; // Add ApiContext created using sdk_config.ini custom settings

return $apiContexts;

/**
 * Create an ApiContext for each chain
 * @param $token
 * @return array
 */
function createApiContextForAllChains($token)
{
    $version = 'v1';

    $chainNames = BlockCypherCoinSymbolConstants::CHAIN_NAMES();

    $apiContexts = array();
    foreach ($chainNames as $chainName) {

        list($coin, $chain) = explode(".", $chainName);
        $coin = strtolower($coin);

        $apiContexts[$chainName] = getApiContextUsingConfigArray($token, $chain, $coin, $version);
    }

    return $apiContexts;
}

/**
 * Helper method for getting an APIContext for all calls (getting config from ini file)
 * @return \BlockCypher\Rest\ApiContext
 */
function getApiContextUsingConfigIni()
{
    // #### SDK configuration
    // Register the sdk_config.ini file in current directory
    // as the configuration source.
    if(!defined("BC_CONFIG_PATH")) {
        define("BC_CONFIG_PATH", __DIR__);
    }

    $apiContext = ApiContext::create('main', 'btc', 'v1');

    return $apiContext;
}

/**
 * Helper method for getting an APIContext for all calls (getting config from array)
 * @param string $token
 * @param string $version v1
 * @param string $coin btc|doge|ltc|uro|bcy
 * @param string $chain main|test3|test
 * @return ApiContext
 */
function getApiContextUsingConfigArray($token, $chain = 'main', $coin = 'btc', $version = 'v1')
{
    $credentials = new SimpleTokenCredential($token);

    $config = array(
        'mode' => 'sandbox',
        'log.LogEnabled' => true,
        'log.FileName' => '../BlockCypher.log',
        'log.LogLevel' => 'DEBUG', // PLEASE USE `INFO` LEVEL FOR LOGGING IN LIVE ENVIRONMENTS
        'validation.level' => 'log',
        // 'http.CURLOPT_CONNECTTIMEOUT' => 30
    );

    $apiContext = ApiContext::create($chain, $coin, $version, $credentials, $config);

    ApiContext::setDefault($apiContext);

    return $apiContext;
}

/**
 * @param $token
 * @return bool
 */
function validateToken($token)
{
    return TokenValidator::validate($token);
}
