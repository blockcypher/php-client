<?php

/**
 * API handler for all REST API calls
 */

namespace BlockCypher\Handler;

use BlockCypher\Core\BlockCypherConstants;
use BlockCypher\Core\BlockCypherHttpConfig;
use BlockCypher\Exception\BlockCypherConfigurationException;
use BlockCypher\Exception\BlockCypherInvalidCredentialException;
use BlockCypher\Exception\BlockCypherMissingCredentialException;

/**
 * Class RestHandler
 */
abstract class RestHandler implements IBlockCypherHandler
{
    /**
     * Private Variable
     *
     * @var \BlockCypher\Rest\ApiContext $apiContext
     */
    protected $apiContext;

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
    abstract public function handle($httpConfig, $request, $options);

    /**
     * End Point
     *
     * @param array $config
     *
     * @return string
     * @throws \BlockCypher\Exception\BlockCypherConfigurationException
     */
    protected function _getEndpoint($config)
    {
        if (isset($config['service.EndPoint'])) {
            return $config['service.EndPoint'];
        } else if (isset($config['mode'])) {
            switch (strtoupper($config['mode'])) {
                case 'SANDBOX':
                    return BlockCypherConstants::REST_SANDBOX_ENDPOINT;
                    break;
                case 'LIVE':
                    return BlockCypherConstants::REST_LIVE_ENDPOINT;
                    break;
                default:
                    throw new BlockCypherConfigurationException('The mode config parameter must be set to either sandbox/live');
                    break;
            }
        } else {
            // Defaulting to Sandbox
            return BlockCypherConstants::REST_SANDBOX_ENDPOINT;
        }
    }
}
