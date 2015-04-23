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
use BlockCypher\Rest\ApiContext;

error_reporting(E_ALL);
ini_set('display_errors', '1');

// Replace these values by entering your own token by visiting https://accounts.blockcypher.com/
/** @noinspection SpellCheckingInspection */
$token = 'c0afcccdde5081d6429de37d16166ead';

if (isset($_GET['token'])) $token = $_GET['token'];
if (!validateToken($token)) {
    echo 'Invalid token. Please get new one: <a href="https://accounts.blockcypher.com/">https://accounts.blockcypher.com/</a>';
    exit(1);
}

/** @var \BlockCypher\Rest\ApiContext $apiContext */
$apiContext = getApiContext($token);

return $apiContext;
/**
 * Helper method for getting an APIContext for all calls
 * @param $token
 * @return ApiContext
 */
function getApiContext($token)
{
    // #### SDK configuration
    // Register the sdk_config.ini file in current directory
    // as the configuration source.
    /*
    if(!defined("PP_CONFIG_PATH")) {
        define("PP_CONFIG_PATH", __DIR__);
    }
    */

    // ### Api context
    // Use an ApiContext object to authenticate
    // API calls. The clientId and clientSecret for the
    // OAuthTokenCredential class can be retrieved from
    // https://accounts.blockcypher.com/

    $apiContext = new ApiContext(
        new SimpleTokenCredential($token)
    );

    // Comment this line out and uncomment the PP_CONFIG_PATH
    // 'define' block if you want to use static file
    // based configuration

    $apiContext->setConfig(
        array(
            'mode' => 'sandbox',
            'log.LogEnabled' => true,
            'log.FileName' => '../BlockCypher.log',
            'log.LogLevel' => 'DEBUG', // PLEASE USE `FINE` LEVEL FOR LOGGING IN LIVE ENVIRONMENTS
            'validation.level' => 'log',
            'cache.enabled' => true,
            // 'http.CURLOPT_CONNECTTIMEOUT' => 30
            // 'http.headers.BlockCypher-Partner-Attribution-Id' => '123123123'
        )
    );

    // Partner Attribution Id
    // Use this header if you are a BlockCypher partner. Specify a unique BN Code to receive revenue attribution.
    // To learn more or to request a BN Code, contact your Partner Manager or visit the BlockCypher Partner Portal
    // $apiContext->addRequestHeader('BlockCypher-Partner-Attribution-Id', '123123123');

    return $apiContext;
}

/**
 * @param $token
 * @return bool
 */
function validateToken($token)
{
    // sample tokens:
    // c0afcccdde5081d6429de37d16166ead
    // ddf3g04f-0f31-4060-978b-63b1ff43e185

    if (strlen($token) < 20) return false;
    if (strlen($token) > 50) return false;
    if (!preg_match('/[a-z0-9-]+/', $token)) return false;

    return true;
}
