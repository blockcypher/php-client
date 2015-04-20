<?php

namespace BlockCypher\Auth;

use BlockCypher\Exception\BlockCypherConfigurationException;

/**
 * Class TokenCredential
 */
interface TokenCredential
{
    /**
     * Get AccessToken
     *
     * @param $config
     *
     * @return null|string
     */
    public function getAccessToken($config);

    /**
     * Get a Refresh Token from Authorization Code
     *
     * @param $config
     * @param $authorizationCode
     * @param array $params optional arrays to override defaults
     * @return string|null
     */
    public function getRefreshToken($config, $authorizationCode = null, $params = array());

    /**
     * Updates Access Token based on given input
     *
     * @param      $config
     * @param string|null $refreshToken
     * @return string
     */
    public function updateAccessToken($config, $refreshToken = null);

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
    public function getToken($config, $clientId, $clientSecret, $payload);

    /**
     * Generates a new access token
     *
     * @param array $config
     * @param null $refreshToken
     * @return null
     */
    public function generateAccessToken($config, $refreshToken = null);
}
