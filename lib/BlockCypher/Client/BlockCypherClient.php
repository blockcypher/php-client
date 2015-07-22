<?php

namespace BlockCypher\Client;

use BlockCypher\Rest\ApiContext;
use BlockCypher\Transport\BlockCypherRestCall;

/**
 * Class BlockCypherClient
 * @package BlockCypher\Client
 */
class BlockCypherClient implements BlockCypherClientInterface
{
    /**
     * Credentials to use for this call
     *
     * @var \BlockCypher\Auth\TokenCredential $credential
     */
    private $credential;

    /**
     * Execute SDK Call to BlockCypher services
     *
     * @param string $url
     * @param string $method
     * @param string $payLoad
     * @param array $headers
     * @param ApiContext $apiContext
     * @param BlockCypherRestCall $restCall
     * @param array $handlers
     * @return string json response of the object
     */
    public function executeCall(
        $url,
        $method,
        $payLoad,
        $headers = array(),
        $apiContext = null,
        $restCall = null,
        $handlers = array('BlockCypher\Handler\TokenRestHandler')
    )
    {
        if ($apiContext === null) {
            $apiContext = $this->getApiContext();
        }

        $restCall = $restCall ? $restCall : new BlockCypherRestCall($apiContext);

        // Make the execution call
        $json = $restCall->execute($handlers, $url, $method, $payLoad, $headers);
        return $json;
    }

    /**
     * @return ApiContext
     */
    public function getApiContext()
    {
        // First try default ApiContext
        $apiContext = ApiContext::getDefault();
        if ($apiContext === null) {
            $apiContext = new ApiContext($this->credential);
            return $apiContext;
        }
        return $apiContext;
    }

    /**
     * @param ApiContext|null $apiContext
     * @return array
     */
    public function getChainUrlPrefix($apiContext)
    {
        if ($apiContext === null) {
            $apiContext = self::getApiContext();
        }
        $chainUrlPrefix = $apiContext->getBaseChainUrl();
        return $chainUrlPrefix;
    }

    /**
     * @param ApiContext|null $apiContext
     * @return string
     */
    public function getCoinSymbol($apiContext)
    {
        if ($apiContext === null) {
            $apiContext = self::getApiContext();
        }
        return $apiContext->getCoinSymbol();
    }
}