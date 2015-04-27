<?php

namespace sample\Test\Functional;

use Goutte\Client;

/**
 * Class WebTestCase
 * @package sample\Test\Functional
 */
class WebTestCase extends \PHPUnit_Framework_TestCase
{
    /**
     * @var string
     */
    protected static $baseUrl;

    /**
     * @var Client
     */
    protected $client;

    /**
     * @var string
     */
    protected $url;

    public function setUp()
    {

        $this->client = new Client();

        $configFile = implode(DIRECTORY_SEPARATOR,
            array(dirname(__FILE__), "sample_config.ini"));

        if ($configs = parse_ini_file($configFile)) {
            self::$baseUrl = $configs['test.baseUrl'];
        }
    }

    public function baseUrl()
    {
        return self::$baseUrl;
    }

    protected function assertNotContainsPhpErrors($responseBody)
    {
        $this->assertNotContains('warning', $responseBody);
        $this->assertNotContains('notice', $responseBody);
        $this->assertNotContains('Parse error', $responseBody);
        $this->assertNotContains('(Failed)', $responseBody);
    }
}