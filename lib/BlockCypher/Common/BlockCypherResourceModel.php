<?php

namespace BlockCypher\Common;

use BlockCypher\Rest\ApiContext;
use BlockCypher\Rest\IResource;
use BlockCypher\Transport\BlockCypherRestCall;

/**
 * Class BlockCypherResourceModel
 * An Executable BlockCypherModel Class
 *
 * @package BlockCypher\Common
 */
class BlockCypherResourceModel extends BlockCypherBaseModel implements IResource
{
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
    protected static function executeCall(
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
            $apiContext = self::getApiContext();
        }

        $restCall = $restCall ? $restCall : new BlockCypherRestCall($apiContext);

        //Make the execution call
        $json = $restCall->execute($handlers, $url, $method, $payLoad, $headers);
        return $json;
    }

    /**
     * @return ApiContext
     */
    protected static function getApiContext()
    {
        // First try default ApiContext
        $apiContext = ApiContext::getDefault();
        if ($apiContext === null) {
            $apiContext = new ApiContext(self::$credential);
            return $apiContext;
        }
        return $apiContext;
    }

    /**
     * @param ApiContext|null $apiContext
     * @return array
     */
    protected static function getChainUrlPrefix($apiContext)
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
    protected static function getCoinSymbol($apiContext)
    {
        if ($apiContext === null) {
            $apiContext = self::getApiContext();
        }
        return $apiContext->getCoinSymbol();
    }
}