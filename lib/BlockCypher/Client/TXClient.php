<?php

namespace BlockCypher\Client;

use BlockCypher\Api\TX;
use BlockCypher\Api\TXConfidence;
use BlockCypher\Api\TXHex;
use BlockCypher\Api\TXSkeleton;
use BlockCypher\Rest\ApiContext;
use BlockCypher\Transport\BlockCypherRestCall;
use BlockCypher\Validation\ArgumentArrayValidator;
use BlockCypher\Validation\ArgumentGetParamsValidator;
use BlockCypher\Validation\ArgumentValidator;

/**
 * Class TXClient
 *
 * @package BlockCypher\Client
 *
 */
class TXClient extends BlockCypherClient
{
    /**
     * Sign the transaction skeleton.
     *
     * @param TXSkeleton $txSkeleton
     * @param string[]|string $privateKeys
     * @param ApiContext $apiContext is the APIContext for this call. It can be used to pass dynamic configuration and credentials.
     * @param BlockCypherRestCall $restCall is the Rest Call Service that is used to make rest calls
     * @return TXSkeleton
     */
    public function sign(TXSkeleton $txSkeleton, $privateKeys, $apiContext = null, $restCall = null)
    {
        $coinSymbol = $this->getCoinSymbol($apiContext);
        return $txSkeleton->sign($privateKeys, $coinSymbol);
    }

    /**
     * Obtain the TX resource for the given identifier.
     *
     * @param string $hash
     * @param array $params Parameters. Options: instart, outstart and limit
     * @param ApiContext $apiContext is the APIContext for this call. It can be used to pass dynamic configuration and credentials.
     * @param BlockCypherRestCall $restCall is the Rest Call Service that is used to make rest calls
     * @return TX
     */
    public function get($hash, $params = array(), $apiContext = null, $restCall = null)
    {
        ArgumentValidator::validate($hash, 'hash');
        ArgumentGetParamsValidator::validate($params, 'params');
        $allowedParams = array(
            'instart' => 1,
            'outstart' => 1,
            'limit' => 1,
            'includeHex' => 1,
        );
        $params = ArgumentGetParamsValidator::sanitize($params, $allowedParams);

        $payLoad = "";

        $chainUrlPrefix = $this->getChainUrlPrefix($apiContext);

        $json = $this->executeCall(
            "$chainUrlPrefix/txs/$hash?" . http_build_query($params),
            "GET",
            $payLoad,
            null,
            $apiContext,
            $restCall
        );
        $ret = new TX();
        $ret->fromJson($json);
        return $ret;
    }

    /**
     * Obtain multiple TX resources for the given identifier.
     *
     * @param string[] $array
     * @param array $params Parameters. Options: instart, outstart and limit
     * @param ApiContext $apiContext is the APIContext for this call. It can be used to pass dynamic configuration and credentials.
     * @param BlockCypherRestCall $restCall is the Rest Call Service that is used to make rest calls
     * @return TX[]
     */
    public function getMultiple($array, $params = array(), $apiContext = null, $restCall = null)
    {
        ArgumentArrayValidator::validate($array, 'array');
        ArgumentGetParamsValidator::validate($params, 'params');
        $allowedParams = array(
            'instart' => 1,
            'outstart' => 1,
            'limit' => 1,
        );
        $params = ArgumentGetParamsValidator::sanitize($params, $allowedParams);

        $transactionList = implode(";", $array);
        $payLoad = "";

        $chainUrlPrefix = $this->getChainUrlPrefix($apiContext);

        $json = $this->executeCall(
            "$chainUrlPrefix/txs/$transactionList?" . http_build_query($params),
            "GET",
            $payLoad,
            null,
            $apiContext,
            $restCall
        );
        return TX::getList($json);
    }

    /**
     * The Unconfirmed Transactions Endpoint returns an array of the latest transactions relayed by nodes
     * in a blockchain that haven’t been included in any blocks.
     *
     * @param array $params Parameters. Options: instart, outstart and limit
     * @param ApiContext $apiContext is the APIContext for this call. It can be used to pass dynamic configuration and credentials.
     * @param BlockCypherRestCall $restCall is the Rest Call Service that is used to make rest calls
     * @return TX[]
     */
    public function getUnconfirmed($params = array(), $apiContext = null, $restCall = null)
    {
        ArgumentGetParamsValidator::validate($params, 'params');
        $allowedParams = array();
        $params = ArgumentGetParamsValidator::sanitize($params, $allowedParams);

        $payLoad = "";

        $chainUrlPrefix = $this->getChainUrlPrefix($apiContext);

        $json = $this->executeCall(
            "$chainUrlPrefix/txs?" . http_build_query($params),
            "GET",
            $payLoad,
            null,
            $apiContext,
            $restCall
        );
        return TX::getList($json);
    }

    /**
     * Decode raw transactions without sending propagating them to the network; perhaps you want to double-check
     * another client library or confirm that another service is sending proper transactions.
     *
     * @param string $hexRawTx
     * @param array $params Parameters. Options: instart, outstart and limit
     * @param ApiContext $apiContext is the APIContext for this call. It can be used to pass dynamic configuration and credentials.
     * @param BlockCypherRestCall $restCall is the Rest Call Service that is used to make rest calls
     * @return TX
     */
    public function decode($hexRawTx, $params = array(), $apiContext = null, $restCall = null)
    {
        ArgumentValidator::validate($hexRawTx, 'hexRawTx');
        ArgumentGetParamsValidator::validate($params, 'params');
        $allowedParams = array();
        $params = ArgumentGetParamsValidator::sanitize($params, $allowedParams);

        $txHex = new TXHex();
        $txHex->setTx($hexRawTx);
        $payLoad = $txHex->toJSON();

        $chainUrlPrefix = $this->getChainUrlPrefix($apiContext);

        $json = $this->executeCall(
            "$chainUrlPrefix/txs/decode?" . http_build_query($params),
            "POST",
            $payLoad,
            null,
            $apiContext,
            $restCall
        );
        $ret = new TX();
        $ret->fromJson($json);
        return $ret;
    }

    /**
     * Push the raw transaction to the network.
     *
     * @param string $hexRawTx
     * @param array $params Parameters. Options: instart, outstart and limit
     * @param ApiContext $apiContext is the APIContext for this call. It can be used to pass dynamic configuration and credentials.
     * @param BlockCypherRestCall $restCall is the Rest Call Service that is used to make rest calls
     * @return TX
     */
    public function push($hexRawTx, $params = array(), $apiContext = null, $restCall = null)
    {
        ArgumentValidator::validate($hexRawTx, 'hexRawTx');
        ArgumentGetParamsValidator::validate($params, 'params');
        $allowedParams = array();
        $params = ArgumentGetParamsValidator::sanitize($params, $allowedParams);

        $txHex = new TXHex();
        $txHex->setTx($hexRawTx);
        $payLoad = $txHex->toJSON();

        $chainUrlPrefix = $this->getChainUrlPrefix($apiContext);

        $json = $this->executeCall(
            "$chainUrlPrefix/txs/push?" . http_build_query($params),
            "POST",
            $payLoad,
            null,
            $apiContext,
            $restCall
        );
        $ret = new TX();
        $ret->fromJson($json);
        return $ret;
    }

    /**
     * Create a new TX.
     *
     * @param TX $tx
     * @param ApiContext $apiContext is the APIContext for this call. It can be used to pass dynamic configuration and credentials.
     * @param BlockCypherRestCall $restCall is the Rest Call Service that is used to make rest calls
     * @return TXSkeleton
     */
    public function create(TX $tx, $apiContext = null, $restCall = null)
    {
        $payLoad = $tx->toJSON();

        $chainUrlPrefix = $this->getChainUrlPrefix($apiContext);

        $json = $this->executeCall(
            "$chainUrlPrefix/txs/new",
            "POST",
            $payLoad,
            null,
            $apiContext,
            $restCall
        );

        $txSkeleton = new TXSkeleton();
        $txSkeleton->fromJson($json);
        return $txSkeleton;
    }

    /**
     * Send the transaction to the network.
     *
     * @param TXSkeleton $txSkeleton
     * @param ApiContext $apiContext is the APIContext for this call. It can be used to pass dynamic configuration and credentials.
     * @param BlockCypherRestCall $restCall is the Rest Call Service that is used to make rest calls
     * @return TXSkeleton
     */
    public function send(TXSkeleton $txSkeleton, $apiContext = null, $restCall = null)
    {
        $payLoad = $txSkeleton->toJSON();

        $chainUrlPrefix = $this->getChainUrlPrefix($apiContext);

        $json = $this->executeCall(
            "$chainUrlPrefix/txs/send",
            "POST",
            $payLoad,
            null,
            $apiContext,
            $restCall
        );

        $returnedTXSkeleton = new TXSkeleton();
        $returnedTXSkeleton->fromJson($json);
        return $returnedTXSkeleton;
    }

    /**
     * Obtain the TXConfidence resource for the given identifier.
     *
     * @param string $txhash
     * @param array $params Parameters
     * @param ApiContext $apiContext is the APIContext for this call. It can be used to pass dynamic configuration and credentials.
     * @param BlockCypherRestCall $restCall is the Rest Call Service that is used to make rest calls
     * @return TXConfidence
     */
    public function getConfidence($txhash, $params = array(), $apiContext = null, $restCall = null)
    {
        ArgumentValidator::validate($txhash, 'txhash');
        ArgumentGetParamsValidator::validate($params, 'params');
        $allowedParams = array();
        $params = ArgumentGetParamsValidator::sanitize($params, $allowedParams);

        $payLoad = "";

        $chainUrlPrefix = $this->getChainUrlPrefix($apiContext);

        $json = $this->executeCall(
            "$chainUrlPrefix/txs/$txhash/confidence" . http_build_query(array_intersect_key($params, $allowedParams)),
            "GET",
            $payLoad,
            null,
            $apiContext,
            $restCall
        );
        $txConfidence = new TXConfidence();
        $txConfidence->fromJson($json);
        return $txConfidence;
    }

    /**
     * Obtain multiple TransactionConfidences resources for the given identifiers.
     *
     * @param string[] $array
     * @param array $params Parameters
     * @param ApiContext $apiContext is the APIContext for this call. It can be used to pass dynamic configuration and credentials.
     * @param BlockCypherRestCall $restCall is the Rest Call Service that is used to make rest calls
     * @return TXConfidence[]
     */
    public function getMultipleConfidences($array, $params = array(), $apiContext = null, $restCall = null)
    {
        ArgumentArrayValidator::validate($array, 'array');
        ArgumentGetParamsValidator::validate($params, 'params');
        $allowedParams = array();
        $params = ArgumentGetParamsValidator::sanitize($params, $allowedParams);

        $payLoad = "";

        $txhashList = implode(";", $array);

        $chainUrlPrefix = $this->getChainUrlPrefix($apiContext);

        $json = $this->executeCall(
            "$chainUrlPrefix/txs/$txhashList/confidence" . http_build_query(array_intersect_key($params, $allowedParams)),
            "GET",
            $payLoad,
            null,
            $apiContext,
            $restCall
        );
        return TXConfidence::getList($json);
    }
}