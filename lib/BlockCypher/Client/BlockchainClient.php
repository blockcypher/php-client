<?php

namespace BlockCypher\Client;

use BlockCypher\Api\Blockchain;
use BlockCypher\Rest\ApiContext;
use BlockCypher\Transport\BlockCypherRestCall;
use BlockCypher\Validation\ArgumentGetParamsValidator;
use BlockCypher\Validation\ArgumentValidator;

/**
 * Class BlockchainClient
 *
 * @package BlockCypher\Client
 *
 */
class BlockchainClient extends BlockCypherClient
{
    /**
     * Obtain the Blockchain resource for the given identifier.
     *
     * @param string $name
     * @param array $params Parameters
     * @param ApiContext $apiContext is the APIContext for this call. It can be used to pass dynamic configuration and credentials.
     * @param BlockCypherRestCall $restCall is the Rest Call Service that is used to make rest calls
     * @return Blockchain
     */
    public function get($name, $params = array(), $apiContext = null, $restCall = null)
    {
        ArgumentValidator::validate($name, 'name');
        ArgumentGetParamsValidator::validate($params, 'params');
        $allowedParams = array();
        $params = ArgumentGetParamsValidator::sanitize($params, $allowedParams);

        if (strpos($name, '.') === FALSE) {
            throw new \InvalidArgumentException("Invalid chain name $name. FORMAT: COIN.chain e.g. BTC.main");
        }

        $payLoad = "";

        if ($apiContext === null) {
            $apiContext = $this->getApiContext();
        }
        $version = $apiContext->getVersion();

        list($coin, $chain) = explode(".", $name);
        $coin = strtolower($coin);

        $json = $this->executeCall(
            "/$version/$coin/$chain" . http_build_query(array_intersect_key($params, $allowedParams)),
            "GET",
            $payLoad,
            null,
            $apiContext,
            $restCall
        );
        $ret = new Blockchain();
        $ret->fromJson($json);
        return $ret;
    }
}