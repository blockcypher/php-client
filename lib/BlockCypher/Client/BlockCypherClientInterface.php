<?php

namespace BlockCypher\Client;

use BlockCypher\Rest\ApiContext;
use BlockCypher\Transport\BlockCypherRestCall;

interface BlockCypherClientInterface
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
    public function executeCall(
        $url,
        $method,
        $payLoad,
        $headers = array(),
        $apiContext = null,
        $restCall = null,
        $handlers = array('BlockCypher\Handler\TokenRestHandler')
    );

    /**
     * @return ApiContext
     */
    public function getApiContext();

    /**
     * @param ApiContext|null $apiContext
     * @return array
     */
    public function getChainUrlPrefix($apiContext);

    /**
     * @param ApiContext|null $apiContext
     * @return string
     */
    public function getCoinSymbol($apiContext);
}