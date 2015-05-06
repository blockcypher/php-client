<?php

/**
 * API handler for all REST API calls
 */

namespace BlockCypher\Handler;

use BlockCypher\Auth\SimpleTokenCredential;
use BlockCypher\Common\BlockCypherUserAgent;
use BlockCypher\Core\BlockCypherConstants;
use BlockCypher\Core\BlockCypherCredentialManager;
use BlockCypher\Core\BlockCypherHttpConfig;
use BlockCypher\Exception\BlockCypherConfigurationException;
use BlockCypher\Exception\BlockCypherInvalidCredentialException;
use BlockCypher\Exception\BlockCypherMissingCredentialException;
use BlockCypher\Rest\ApiContext;

/**
 * Class TokenRestHandler
 */
class TokenRestHandler extends RestHandler
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

            $credential = new SimpleTokenCredential($credValues['accessToken']);
        }

        if ($credential == null || !($credential instanceof SimpleTokenCredential)) {
            throw new BlockCypherInvalidCredentialException("Invalid credentials passed");
        }

        $path = (isset($options['path']) ? $options['path'] : '');
        $url = $this->getAbsoluteUrl($path, $this->apiContext);

        $httpConfig->setUrl($url);

        if (!array_key_exists("User-Agent", $httpConfig->getHeaders())) {
            $httpConfig->addHeader("User-Agent", BlockCypherUserAgent::getValue(BlockCypherConstants::SDK_NAME, BlockCypherConstants::SDK_VERSION));
        }

        /*if (!is_null($credential) && $credential instanceof SimpleTokenCredential && is_null($httpConfig->getHeader('Authorization'))) {
            $httpConfig->addHeader('Authorization', "Bearer " . $credential->getAccessToken($config), false);
        }*/

        if ($httpConfig->getMethod() == 'POST' || $httpConfig->getMethod() == 'PUT') {
            $httpConfig->addHeader('BlockCypher-Request-Id', $this->apiContext->getRequestId());
        }
        // Add any additional Headers that they may have provided
        $headers = $this->apiContext->getRequestHeaders();
        foreach ($headers as $key => $value) {
            $httpConfig->addHeader($key, $value);
        }
    }

    /**
     * @param array $path
     * @param ApiContext $apiContext
     * @return string
     * @throws BlockCypherConfigurationException
     */
    private function getAbsoluteUrl($path, $apiContext)
    {
        $credential = $apiContext->getCredential();
        $config = $apiContext->getConfig();

        $endPoint = rtrim(trim($this->_getEndpoint($config)), '/');
        $path = rtrim(trim($path, '/'));
        $url = $endPoint . '/' . $path;
        $url = $this->addTokenToUrl($url, $credential->getAccessToken($config));
        return $url;
    }

    /**
     * @param string $url
     * @param $token
     * @return string
     */
    private function addTokenToUrl($url, $token)
    {
        // TODO: add test for this method.

        // Check url already contains the token
        if ($this->urlContainsToken($url))
            return $url;

        // Returns a string if the URL has parameters or NULL if not
        $query = parse_url($url, PHP_URL_QUERY);

        if ($query === null) {
            // url already ends with ?
            if (substr($url, -1) == '?')
                $urlWithToken = $url . "token={$token}";
            else
                $urlWithToken = $url . "?token={$token}";
        } else {
            $urlWithToken = $url . "&token={$token}";
        }

        return $urlWithToken;
    }

    /**
     * Return true if the given url contains a parameter called 'token'.
     *
     * @param $url
     * @return bool
     */
    private function urlContainsToken($url)
    {
        // TODO: add test for this method.

        $query = parse_url($url, PHP_URL_QUERY);
        parse_str($query, $params);
        if (isset($params["token"])) {
            return true;
        } else {
            return false;
        }
    }
}
