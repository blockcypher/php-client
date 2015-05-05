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
class BlockCypherResourceModel extends BlockCypherModel implements IResource
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
        //Initialize the context and rest call object if not provided explicitly
        if ($apiContext === null) {
            // First try default ApiContext
            $apiContext = ApiContext::getDefault();
            if ($apiContext === null) {
                $apiContext = new ApiContext(self::$credential);
            }
        }

        $restCall = $restCall ? $restCall : new BlockCypherRestCall($apiContext);

        //Make the execution call
        $json = $restCall->execute($handlers, $url, $method, $payLoad, $headers);
        return $json;
    }
}