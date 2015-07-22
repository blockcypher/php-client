<?php

namespace BlockCypher\Client;

use BlockCypher\Api\Block;
use BlockCypher\Rest\ApiContext;
use BlockCypher\Transport\BlockCypherRestCall;
use BlockCypher\Validation\ArgumentArrayValidator;
use BlockCypher\Validation\ArgumentGetParamsValidator;
use BlockCypher\Validation\ArgumentValidator;

/**
 * Class BlockClient
 *
 * @package BlockCypher\Client
 *
 */
class BlockClient extends BlockCypherClient
{
    /**
     * Obtain the Block resource for the given identifier (hash or height).
     *
     * @param string $hashOrHeight
     * @param array $params Parameters. Options: txstart, and limit
     * @param ApiContext $apiContext is the APIContext for this call. It can be used to pass dynamic configuration and credentials.
     * @param BlockCypherRestCall $restCall is the Rest Call Service that is used to make rest calls
     * @return Block
     */
    public function get($hashOrHeight, $params = array(), $apiContext = null, $restCall = null)
    {
        ArgumentValidator::validate($hashOrHeight, 'hashOrHeight');
        ArgumentGetParamsValidator::validate($params, 'params');
        $allowedParams = array(
            'txstart' => 1,
            'limit' => 1,
        );
        $params = ArgumentGetParamsValidator::sanitize($params, $allowedParams);

        $payLoad = "";

        $chainUrlPrefix = $this->getChainUrlPrefix($apiContext);

        $json = $this->executeCall(
            "$chainUrlPrefix/blocks/$hashOrHeight?" . http_build_query($params),
            "GET",
            $payLoad,
            null,
            $apiContext,
            $restCall
        );
        $ret = new Block();
        $ret->fromJson($json);
        return $ret;
    }

    /**
     * Obtain multiple Block resources for the given identifiers (hash or height).
     *
     * @param string[] $array
     * @param array $params Parameters. Options: txstart, and limit
     * @param ApiContext $apiContext is the APIContext for this call. It can be used to pass dynamic configuration and credentials.
     * @param BlockCypherRestCall $restCall is the Rest Call Service that is used to make rest calls
     * @return Block[]
     */
    public function getMultiple($array, $params = array(), $apiContext = null, $restCall = null)
    {
        ArgumentArrayValidator::validate($array, 'array');
        ArgumentGetParamsValidator::validate($params, 'params');
        $allowedParams = array(
            'txstart' => 1,
            'limit' => 1,
        );
        $params = ArgumentGetParamsValidator::sanitize($params, $allowedParams);

        $blockList = implode(";", $array);
        $payLoad = "";

        $chainUrlPrefix = $this->getChainUrlPrefix($apiContext);

        $json = $this->executeCall(
            "$chainUrlPrefix/blocks/$blockList?" . http_build_query($params),
            "GET",
            $payLoad,
            null,
            $apiContext,
            $restCall
        );
        return Block::getList($json);
    }
}