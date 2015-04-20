<?php

/**
 * API handler for all REST API calls
 */

namespace BlockCypher\Handler;

use BlockCypher\Auth\OAuthTokenCredential;
use BlockCypher\Common\BlockCypherUserAgent;
use BlockCypher\Core\BlockCypherConstants;
use BlockCypher\Core\BlockCypherCredentialManager;
use BlockCypher\Core\BlockCypherHttpConfig;
use BlockCypher\Exception\BlockCypherConfigurationException;
use BlockCypher\Exception\BlockCypherInvalidCredentialException;
use BlockCypher\Exception\BlockCypherMissingCredentialException;

/**
 * Class OauthRestHandler
 */
class OauthRestHandler extends RestHandler
{
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
        $credential = $this->apiContext->getCredential();
        $config = $this->apiContext->getConfig();

        if ($credential == null) {
            // Try picking credentials from the config file
            $credMgr = BlockCypherCredentialManager::getInstance($config);
            $credValues = $credMgr->getCredentialObject();

            if (!is_array($credValues)) {
                throw new BlockCypherMissingCredentialException("Empty or invalid credentials passed");
            }

            $credential = new OAuthTokenCredential($credValues['clientId'], $credValues['clientSecret']);
        }

        if ($credential == null || !($credential instanceof OAuthTokenCredential)) {
            throw new BlockCypherInvalidCredentialException("Invalid credentials passed");
        }

        $httpConfig->setUrl(
            rtrim(trim($this->_getEndpoint($config)), '/') .
            (isset($options['path']) ? $options['path'] : '')
        );


        if (!array_key_exists("User-Agent", $httpConfig->getHeaders())) {
            $httpConfig->addHeader("User-Agent", BlockCypherUserAgent::getValue(BlockCypherConstants::SDK_NAME, BlockCypherConstants::SDK_VERSION));
        }

        if (!is_null($credential) && $credential instanceof OAuthTokenCredential && is_null($httpConfig->getHeader('Authorization'))) {
            $httpConfig->addHeader('Authorization', "Bearer " . $credential->getAccessToken($config), false);
        }

        if ($httpConfig->getMethod() == 'POST' || $httpConfig->getMethod() == 'PUT') {
            $httpConfig->addHeader('BlockCypher-Request-Id', $this->apiContext->getRequestId());
        }
        // Add any additional Headers that they may have provided
        $headers = $this->apiContext->getRequestHeaders();
        foreach ($headers as $key => $value) {
            $httpConfig->addHeader($key, $value);
        }
    }
}
