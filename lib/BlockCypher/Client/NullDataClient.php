<?php

namespace BlockCypher\Client;

use BlockCypher\Api\NullData;
use BlockCypher\Rest\ApiContext;
use BlockCypher\Transport\BlockCypherRestCall;
use BlockCypher\Validation\ArgumentGetParamsValidator;

/**
 * Class NullDataClient
 *
 * @package BlockCypher\Client
 *
 */
class NullDataClient extends BlockCypherClient
{
    /**
     * @param string $plainTextData
     * @param array $params
     * @param ApiContext $apiContext
     * @param BlockCypherRestCall $restCall
     * @return NullData
     */
    public function embedString($plainTextData, $params = array(), $apiContext = null, $restCall = null)
    {
        return $this->embed($plainTextData, 'string', $params, $apiContext, $restCall);
    }

    /**
     * @param string $data
     * @param string $encoding 'string' or 'hex'
     * @param array $params
     * @param ApiContext|null $apiContext
     * @param BlockCypherRestCall|null $restCall
     * @return NullData
     */
    public function embed($data, $encoding = 'hex', $params = array(), $apiContext = null, $restCall = null)
    {
        $nullData = new NullData();
        $nullData->setEncoding($encoding);
        $nullData->setData($data); // max 40 bytes

        return $this->create($nullData, $params, $apiContext, $restCall);
    }

    /**
     * Allow to embed small pieces of data on the blockchain.
     *
     * @param NullData $nullData
     * @param array $params Parameters
     * @param ApiContext $apiContext is the APIContext for this call. It can be used to pass dynamic configuration and credentials.
     * @param BlockCypherRestCall $restCall is the Rest Call Service that is used to make rest calls
     * @return NullData
     */
    public function create(NullData $nullData, $params = array(), $apiContext = null, $restCall = null)
    {
        ArgumentGetParamsValidator::validate($params, 'params');
        $allowedParams = array();
        $params = ArgumentGetParamsValidator::sanitize($params, $allowedParams);

        $payLoad = $nullData->toJSON();

        $chainUrlPrefix = self::getChainUrlPrefix($apiContext);

        $json = self::executeCall(
            "$chainUrlPrefix/txs/data?" . http_build_query($params),
            "POST",
            $payLoad,
            null,
            $apiContext,
            $restCall
        );
        $nullData->fromJson($json);
        return $nullData;
    }

    /**
     * @param string $hexEncodedData
     * @param array $params
     * @param ApiContext $apiContext
     * @param BlockCypherRestCall $restCall
     * @return NullData
     */
    public function embedHex($hexEncodedData, $params = array(), $apiContext = null, $restCall = null)
    {
        return $this->embed($hexEncodedData, 'hex', $params, $apiContext, $restCall);
    }
}