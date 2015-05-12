<?php

namespace BlockCypher\Api;

use BlockCypher\Common\BlockCypherResourceModel;
use BlockCypher\Rest\ApiContext;
use BlockCypher\Transport\BlockCypherRestCall;
use BlockCypher\Validation\ArgumentArrayValidator;
use BlockCypher\Validation\ArgumentGetParamsValidator;
use BlockCypher\Validation\ArgumentValidator;

/**
 * Class TransactionConfidence
 *
 * A resource representing a block.
 *
 * @package BlockCypher\Api
 *
 * @property int age_millis
 * @property int receive_count
 * @property float confidence
 * @property string txhash
 * @property string txurl
 */
class TransactionConfidence extends BlockCypherResourceModel
{
    // TODO: add description for setters and getters from http://dev.blockcypher.com/ (not currently available)

    /**
     * Obtain the TransactionConfidence resource for the given identifier.
     *
     * @param string $txhash
     * @param array $params Parameters
     * @param ApiContext $apiContext is the APIContext for this call. It can be used to pass dynamic configuration and credentials.
     * @param BlockCypherRestCall $restCall is the Rest Call Service that is used to make rest calls
     * @return TransactionConfidence
     */
    public static function get($txhash, $params = array(), $apiContext = null, $restCall = null)
    {
        ArgumentValidator::validate($txhash, 'txhash');
        ArgumentGetParamsValidator::validate($params, 'params');
        $allowedParams = array();
        $params = ArgumentGetParamsValidator::sanitize($params, $allowedParams);

        $payLoad = "";

        $chainUrlPrefix = self::getChainUrlPrefix($apiContext);

        $json = self::executeCall(
            "$chainUrlPrefix/txs/$txhash/confidence" . http_build_query(array_intersect_key($params, $allowedParams)),
            "GET",
            $payLoad,
            null,
            $apiContext,
            $restCall
        );
        $ret = new TransactionConfidence();
        $ret->fromJson($json);
        return $ret;
    }

    /**
     * Obtain multiple TransactionConfidences resources for the given identifiers.
     *
     * @param string[] $array
     * @param array $params Parameters
     * @param ApiContext $apiContext is the APIContext for this call. It can be used to pass dynamic configuration and credentials.
     * @param BlockCypherRestCall $restCall is the Rest Call Service that is used to make rest calls
     * @return TransactionConfidence[]
     */
    public static function getMultiple($array, $params = array(), $apiContext = null, $restCall = null)
    {
        ArgumentArrayValidator::validate($array, 'array');
        ArgumentGetParamsValidator::validate($params, 'params');
        $allowedParams = array();
        $params = ArgumentGetParamsValidator::sanitize($params, $allowedParams);

        $payLoad = "";

        $txhashList = implode(";", $array);

        $chainUrlPrefix = self::getChainUrlPrefix($apiContext);

        $json = self::executeCall(
            "$chainUrlPrefix/txs/$txhashList/confidence" . http_build_query(array_intersect_key($params, $allowedParams)),
            "GET",
            $payLoad,
            null,
            $apiContext,
            $restCall
        );
        return TransactionConfidence::getList($json);
    }

    /**
     * @return int
     */
    public function getAgeMillis()
    {
        return $this->age_millis;
    }

    /**
     * @param int $age_millis
     * @return $this
     */
    public function setAgeMillis($age_millis)
    {
        $this->age_millis = $age_millis;
        return $this;
    }

    /**
     * @return int
     */
    public function getReceiveCount()
    {
        return $this->receive_count;
    }

    /**
     * @param int $receive_count
     * @return $this
     */
    public function setReceiveCount($receive_count)
    {
        $this->receive_count = $receive_count;
        return $this;
    }

    /**
     * @return float
     */
    public function getConfidence()
    {
        return $this->confidence;
    }

    /**
     * @param float $confidence
     * @return $this
     */
    public function setConfidence($confidence)
    {
        $this->confidence = $confidence;
        return $this;
    }

    /**
     * @return string
     */
    public function getTxhash()
    {
        return $this->txhash;
    }

    /**
     * @param string $txhash
     * @return $this
     */
    public function setTxhash($txhash)
    {
        $this->txhash = $txhash;
        return $this;
    }

    /**
     * @return string
     */
    public function getTxurl()
    {
        return $this->txurl;
    }

    /**
     * @param string $txurl
     * @return $this
     */
    public function setTxurl($txurl)
    {
        $this->txurl = $txurl;
        return $this;
    }
}