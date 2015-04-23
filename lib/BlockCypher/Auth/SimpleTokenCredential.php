<?php

namespace BlockCypher\Auth;

use BlockCypher\Common\BlockCypherResourceModel;
use BlockCypher\Core\BlockCypherHttpConfig;
use BlockCypher\Core\BlockCypherHttpConnection;
use BlockCypher\Core\BlockCypherLoggingManager;
use BlockCypher\Exception\BlockCypherConfigurationException;
use BlockCypher\Handler\IBlockCypherHandler;
use BlockCypher\Rest\ApiContext;

/**
 * Class SimpleTokenCredential
 */
class SimpleTokenCredential extends BlockCypherResourceModel implements TokenCredential
{

    public static $CACHE_PATH = '/../../../var/auth.cache';

    /**
     * @var string Default Auth Handler
     */
    public static $AUTH_HANDLER = 'BlockCypher\Handler\TokenHandler';

    /**
     * Private Variable
     *
     * @var \BlockCypher\Core\BlockCypherLoggingManager $logger
     */
    private $logger;

    /**
     * Generated Access Token
     *
     * @var string $accessToken
     */
    private $accessToken;

    /**
     * Construct
     *
     * @param null $accessToken
     */
    public function __construct($accessToken)
    {
        $this->accessToken = $accessToken;
        $this->logger = BlockCypherLoggingManager::getInstance(__CLASS__);
    }

    /**
     * Get AccessToken
     *
     * @param $config
     *
     * @return null|string
     */
    public function getAccessToken($config)
    {
        return $this->accessToken;
    }


    /**
     * Get a Refresh Token from Authorization Code
     *
     * @param $config
     * @param $authorizationCode
     * @param array $params optional arrays to override defaults
     * @return string|null
     */
    public function getRefreshToken($config, $authorizationCode = null, $params = array())
    {
        return $this->accessToken;
    }

    /**
     * Updates Access Token based on given input
     *
     * @param      $config
     * @param string|null $refreshToken
     * @return string
     */
    public function updateAccessToken($config, $refreshToken = null)
    {
        $this->generateAccessToken($config, $refreshToken);

        return $this->accessToken;
    }

    /**
     * Generates a new access token
     *
     * @param array $config
     * @param null $refreshToken
     * @return string
     */
    public function generateAccessToken($config, $refreshToken = null)
    {
        return $this->accessToken;
    }

    /**
     * Retrieves the token based on the input configuration
     *
     * @param array $config
     * @param string $clientId
     * @param string $clientSecret
     * @param string $payload
     * @return mixed
     * @throws BlockCypherConfigurationException
     * @throws \BlockCypher\Exception\BlockCypherConnectionException
     */
    public function getToken($config, $clientId, $clientSecret, $payload)
    {
        $httpConfig = new BlockCypherHttpConfig(null, 'POST', $config);

        $handlers = array(self::$AUTH_HANDLER);

        /** @var IBlockCypherHandler $handler */
        foreach ($handlers as $handler) {
            if (!is_object($handler)) {
                $fullHandler = "\\" . (string)$handler;
                $handler = new $fullHandler(new ApiContext($this));
            }
            $handler->handle($httpConfig, $payload, array('clientId' => $clientId, 'clientSecret' => $clientSecret));
        }

        $connection = new BlockCypherHttpConnection($httpConfig, $config);
        $res = $connection->execute($payload);
        $response = json_decode($res, true);

        return $response;
    }


}
