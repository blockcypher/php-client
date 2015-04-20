<?php

/**
 * API handler for OAuth Token Request REST API calls
 */

namespace BlockCypher\Handler;

use BlockCypher\Common\BlockCypherUserAgent;
use BlockCypher\Core\BlockCypherConstants;
use BlockCypher\Core\BlockCypherHttpConfig;
use BlockCypher\Exception\BlockCypherConfigurationException;
use BlockCypher\Exception\BlockCypherInvalidCredentialException;
use BlockCypher\Exception\BlockCypherMissingCredentialException;

/**
 * Class OauthHandler
 */
class OauthHandler implements IBlockCypherHandler
{
    /**
     * Private Variable
     *
     * @var \BlockCypher\Rest\ApiContext $apiContext
     */
    private $apiContext;

    /**
     * Construct
     *
     * @param \BlockCypher\Rest\ApiContext $apiContext
     */
    public function __construct($apiContext)
    {
        $this->apiContext = $apiContext;
    }

    /**
     * @param BlockCypherHttpConfig $httpConfig
     * @param string $request
     * @param mixed $options
     * @return mixed|void
     * @throws BlockCypherConfigurationException
     * @throws BlockCypherInvalidCredentialException
     * @throws BlockCypherMissingCredentialException
     */
    public function handle($httpConfig, $request, $options)
    {
        $config = $this->apiContext->getConfig();

        $httpConfig->setUrl(
            rtrim(trim($this->_getEndpoint($config)), '/') .
            (isset($options['path']) ? $options['path'] : '')
        );

        $headers = array(
            "User-Agent" => BlockCypherUserAgent::getValue(BlockCypherConstants::SDK_NAME, BlockCypherConstants::SDK_VERSION),
            "Authorization" => "Basic " . base64_encode($options['clientId'] . ":" . $options['clientSecret']),
            "Accept" => "*/*"
        );
        $httpConfig->setHeaders($headers);

        // Add any additional Headers that they may have provided
        $headers = $this->apiContext->getRequestHeaders();
        foreach ($headers as $key => $value) {
            $httpConfig->addHeader($key, $value);
        }
    }

    /**
     * Get HttpConfiguration object for OAuth API
     *
     * @param array $config
     *
     * @return BlockCypherHttpConfig
     * @throws \BlockCypher\Exception\BlockCypherConfigurationException
     */
    private static function _getEndpoint($config)
    {
        if (isset($config['oauth.EndPoint'])) {
            $baseEndpoint = $config['oauth.EndPoint'];
        } else if (isset($config['service.EndPoint'])) {
            $baseEndpoint = $config['service.EndPoint'];
        } else if (isset($config['mode'])) {
            switch (strtoupper($config['mode'])) {
                case 'SANDBOX':
                    $baseEndpoint = BlockCypherConstants::REST_SANDBOX_ENDPOINT;
                    break;
                case 'LIVE':
                    $baseEndpoint = BlockCypherConstants::REST_LIVE_ENDPOINT;
                    break;
                default:
                    throw new BlockCypherConfigurationException('The mode config parameter must be set to either sandbox/live');
            }
        } else {
            // Defaulting to Sandbox
            $baseEndpoint = BlockCypherConstants::REST_SANDBOX_ENDPOINT;
        }

        $baseEndpoint = rtrim(trim($baseEndpoint), '/') . "/v1/oauth2/token";

        return $baseEndpoint;
    }
}
