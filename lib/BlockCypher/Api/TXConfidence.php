<?php

namespace BlockCypher\Api;

use BlockCypher\Common\BlockCypherResourceModel;
use BlockCypher\Rest\ApiContext;
use BlockCypher\Transport\BlockCypherRestCall;
use BlockCypher\Validation\ArgumentArrayValidator;
use BlockCypher\Validation\ArgumentGetParamsValidator;
use BlockCypher\Validation\ArgumentValidator;

/**
 * Class TXConfidence
 *
 * A TXConfidence represents information about the confidence that an unconfirmed transaction will make it into
 * the next block. Typically used as a return object from the Transaction Confidence Endpoint.
 *
 * @package BlockCypher\Api
 *
 * @property int age_millis
 * @property int receive_count
 * @property float confidence
 * @property string txhash
 * @property string txurl
 */
class TXConfidence extends BlockCypherResourceModel
{
    /**
     * Obtain the TXConfidence resource for the given identifier.
     *
     * @deprecated since version 1.2.1 Use TXClient.
     * @param string $txhash
     * @param array $params Parameters
     * @param ApiContext $apiContext is the APIContext for this call. It can be used to pass dynamic configuration and credentials.
     * @param BlockCypherRestCall $restCall is the Rest Call Service that is used to make rest calls
     * @return TXConfidence
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
        $ret = new TXConfidence();
        $ret->fromJson($json);
        return $ret;
    }

    /**
     * Obtain multiple TransactionConfidences resources for the given identifiers.
     *
     * @deprecated since version 1.2.1 Use TXClient.
     * @param string[] $array
     * @param array $params Parameters
     * @param ApiContext $apiContext is the APIContext for this call. It can be used to pass dynamic configuration and credentials.
     * @param BlockCypherRestCall $restCall is the Rest Call Service that is used to make rest calls
     * @return TXConfidence[]
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
        return TXConfidence::getList($json);
    }

    /**
     * The age of the transaction in milliseconds, based on the earliest time BlockCypher saw it relayed in the network.
     *
     * @return int
     */
    public function getAgeMillis()
    {
        return $this->age_millis;
    }

    /**
     * The age of the transaction in milliseconds, based on the earliest time BlockCypher saw it relayed in the network.
     *
     * @param int $age_millis
     * @return $this
     */
    public function setAgeMillis($age_millis)
    {
        $this->age_millis = $age_millis;
        return $this;
    }

    /**
     * Number of peers that have sent this transaction to BlockCypher; only positive for unconfirmed transactions.
     * -1 for confirmed transactions.
     *
     * @return int
     */
    public function getReceiveCount()
    {
        return $this->receive_count;
    }

    /**
     * Number of peers that have sent this transaction to BlockCypher; only positive for unconfirmed transactions.
     * -1 for confirmed transactions.
     *
     * @param int $receive_count
     * @return $this
     */
    public function setReceiveCount($receive_count)
    {
        $this->receive_count = $receive_count;
        return $this;
    }

    /**
     * A number from 0 to 1 representing BlockCypher’s confidence that the transaction will make it into the next block.
     *
     * @return float
     */
    public function getConfidence()
    {
        return $this->confidence;
    }

    /**
     * A number from 0 to 1 representing BlockCypher’s confidence that the transaction will make it into the next block.
     *
     * @param float $confidence
     * @return $this
     */
    public function setConfidence($confidence)
    {
        $this->confidence = $confidence;
        return $this;
    }

    /**
     * The hash of the transaction. While reasonably unique, using hashes as identifiers may be unsafe.
     *
     * @return string
     */
    public function getTxhash()
    {
        return $this->txhash;
    }

    /**
     * The hash of the transaction. While reasonably unique, using hashes as identifiers may be unsafe.
     *
     * @param string $txhash
     * @return $this
     */
    public function setTxhash($txhash)
    {
        $this->txhash = $txhash;
        return $this;
    }

    /**
     * The BlockCypher URL one can use to query more detailed information about this transaction.
     *
     * @return string
     */
    public function getTxurl()
    {
        return $this->txurl;
    }

    /**
     * The BlockCypher URL one can use to query more detailed information about this transaction.
     *
     * @param string $txurl
     * @return $this
     */
    public function setTxurl($txurl)
    {
        $this->txurl = $txurl;
        return $this;
    }
}