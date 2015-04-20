<?php

namespace BlockCypher\Test\Handler;

use BlockCypher\Auth\OAuthTokenCredential;
use BlockCypher\Core\BlockCypherHttpConfig;
use BlockCypher\Handler\OauthHandler;
use BlockCypher\Rest\ApiContext;

class OauthHandlerTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var \BlockCypher\Handler\OauthHandler
     */
    public $handler;

    /**
     * @var BlockCypherHttpConfig
     */
    public $httpConfig;

    /**
     * @var ApiContext
     */
    public $apiContext;

    /**
     * @var array
     */
    public $config;

    public function setUp()
    {
        $this->apiContext = new ApiContext(
            new OAuthTokenCredential(
                'clientId',
                'clientSecret'
            )
        );

    }

    public function modeProvider()
    {
        return array(
            array(array('mode' => 'sandbox')),
            array(array('mode' => 'live')),
            array(array('mode' => 'sandbox', 'oauth.EndPoint' => 'http://localhost/')),
            array(array('mode' => 'sandbox', 'service.EndPoint' => 'http://service.localhost/'))
        );
    }


    /**
     * @dataProvider modeProvider
     * @param $configs
     */
    public function testGetEndpoint($configs)
    {
        $config = $configs + array(
                'cache.enabled' => true,
                'http.headers.header1' => 'header1value'
            );
        $this->apiContext->setConfig($config);
        $this->httpConfig = new BlockCypherHttpConfig(null, 'POST', $config);
        $this->handler = new OauthHandler($this->apiContext);
        $this->handler->handle($this->httpConfig, null, $this->config);
    }


}
