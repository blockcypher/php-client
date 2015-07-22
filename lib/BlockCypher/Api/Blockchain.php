<?php

namespace BlockCypher\Api;

use BlockCypher\Common\BlockCypherResourceModel;
use BlockCypher\Rest\ApiContext;
use BlockCypher\Transport\BlockCypherRestCall;
use BlockCypher\Validation\ArgumentGetParamsValidator;
use BlockCypher\Validation\ArgumentValidator;


/**
 * Class Blockchain
 *
 * A Blockchain represents the current state of a particular blockchain
 * from the Coin/Chain resources that BlockCypher supports. Typically returned from the Chain API endpoint.
 *
 * @package BlockCypher\Api
 *
 * @property string name
 * @property int height
 * @property string hash
 * @property string time
 * @property string latest_url
 * @property string previous_hash
 * @property string previous_url
 * @property int peer_count
 * @property int unconfirmed_count
 * @property int high_fee_per_kb
 * @property int medium_fee_per_kb
 * @property int low_fee_per_kb
 * @property int last_fork_height
 * @property string last_fork_hash
 */
class Blockchain extends BlockCypherResourceModel
{
    /**
     * Obtain the Blockchain resource for the given identifier.
     *
     * @deprecated since version 1.2. Use BlockchainClient.
     * @param string $name
     * @param array $params Parameters
     * @param ApiContext $apiContext is the APIContext for this call. It can be used to pass dynamic configuration and credentials.
     * @param BlockCypherRestCall $restCall is the Rest Call Service that is used to make rest calls
     * @return Blockchain
     */
    public static function get($name, $params = array(), $apiContext = null, $restCall = null)
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
            $apiContext = self::getApiContext();
        }
        $version = $apiContext->getVersion();

        list($coin, $chain) = explode(".", $name);
        $coin = strtolower($coin);

        $json = self::executeCall(
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

    /**
     * The name of the blockchain represented, in the form of $COIN.$CHAIN.
     *
     * @param $name
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * The name of the blockchain represented, in the form of $COIN.$CHAIN.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * The current height of the blockchain; i.e., the number of blocks in the blockchain.
     * @return int
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * The current height of the blockchain; i.e., the number of blocks in the blockchain.
     * @param int $height
     * @return $this
     */
    public function setHeight($height)
    {
        $this->height = $height;
        return $this;
    }

    /**
     * The hash of the latest confirmed block in the blockchain;
     * in Bitcoin, the hashing function is SHA256(SHA256(block)).
     * @return string
     */
    public function getHash()
    {
        return $this->hash;
    }

    /**
     * The hash of the latest confirmed block in the blockchain;
     * in Bitcoin, the hashing function is SHA256(SHA256(block)).
     * @param string $hash
     * @return $this
     */
    public function setHash($hash)
    {
        $this->hash = $hash;
        return $this;
    }

    /**
     * The time of the latest update to the blockchain; typically when the latest block was added.
     * @return string
     */
    public function getTime()
    {
        return $this->time;
    }

    /**
     * The time of the latest update to the blockchain; typically when the latest block was added.
     * @param string $time
     * @return $this
     */
    public function setTime($time)
    {
        $this->time = $time;
        return $this;
    }

    /**
     * The BlockCypher URL to query for more information on the latest confirmed block; returns a Block.
     *
     * @return string
     */
    public function getLatestUrl()
    {
        return $this->latest_url;
    }

    /**
     * The BlockCypher URL to query for more information on the latest confirmed block; returns a Block.
     *
     * @param string $latest_url
     * @return $this
     */
    public function setLatestUrl($latest_url)
    {
        $this->latest_url = $latest_url;
        return $this;
    }

    /**
     * The hash of the second-to-latest confirmed block in the blockchain.
     *
     * @return string
     */
    public function getPreviousHash()
    {
        return $this->previous_hash;
    }

    /**
     * The hash of the second-to-latest confirmed block in the blockchain.
     *
     * @param string $previous_hash
     * @return $this
     */
    public function setPreviousHash($previous_hash)
    {
        $this->previous_hash = $previous_hash;
        return $this;
    }

    /**
     * The BlockCypher URL to query for more information on the second-to-latest confirmed block; returns a Block.
     *
     * @return string
     */
    public function getPreviousUrl()
    {
        return $this->previous_url;
    }

    /**
     * The BlockCypher URL to query for more information on the second-to-latest confirmed block; returns a Block.
     *
     * @param string $previous_url
     * @return $this
     */
    public function setPreviousUrl($previous_url)
    {
        $this->previous_url = $previous_url;
        return $this;
    }

    /**
     * N/A, will be deprecated soon.
     *
     * @return int
     */
    public function getPeerCount()
    {
        return $this->peer_count;
    }

    /**
     * N/A, will be deprecated soon.
     *
     * @param int $peer_count
     * @return $this
     */
    public function setPeerCount($peer_count)
    {
        $this->peer_count = $peer_count;
        return $this;
    }

    /**
     * Number of unconfirmed transactions in memory pool (likely to be included in next block).
     *
     * @return int
     */
    public function getUnconfirmedCount()
    {
        return $this->unconfirmed_count;
    }

    /**
     * Number of unconfirmed transactions in memory pool (likely to be included in next block).
     *
     * @param int $unconfirmed_count
     * @return $this
     */
    public function setUnconfirmedCount($unconfirmed_count)
    {
        $this->unconfirmed_count = $unconfirmed_count;
        return $this;
    }

    /**
     * A rolling average of the fee (in satoshis) paid per kilobyte for transactions to be confirmed within 1 to 2 blocks.
     *
     * @return int
     */
    public function getHighFeePerKb()
    {
        return $this->high_fee_per_kb;
    }

    /**
     * A rolling average of the fee (in satoshis) paid per kilobyte for transactions to be confirmed within 1 to 2 blocks.
     *
     * @param int $high_fee_per_kb
     */
    public function setHighFeePerKb($high_fee_per_kb)
    {
        $this->high_fee_per_kb = $high_fee_per_kb;
    }

    /**
     * A rolling average of the fee (in satoshis) paid per kilobyte for transactions to be confirmed within 3 to 6 blocks.
     *
     * @return int
     */
    public function getMediumFeePerKb()
    {
        return $this->medium_fee_per_kb;
    }

    /**
     * A rolling average of the fee (in satoshis) paid per kilobyte for transactions to be confirmed within 3 to 6 blocks.
     *
     * @param int $medium_fee_per_kb
     */
    public function setMediumFeePerKb($medium_fee_per_kb)
    {
        $this->medium_fee_per_kb = $medium_fee_per_kb;
    }

    /**
     * A rolling average of the fee (in satoshis) paid per kilobyte for transactions to be confirmed in 7 or more blocks.
     *
     * @return int
     */
    public function getLowFeePerKb()
    {
        return $this->low_fee_per_kb;
    }

    /**
     * A rolling average of the fee (in satoshis) paid per kilobyte for transactions to be confirmed in 7 or more blocks.
     *
     * @param int $low_fee_per_kb
     */
    public function setLowFeePerKb($low_fee_per_kb)
    {
        $this->low_fee_per_kb = $low_fee_per_kb;
    }

    /**
     * Optional The current height of the latest fork to the blockchain;
     * when no competing blockchain fork present, not returned with endpoints that return Blockchains.
     *
     * @return int
     */
    public function getLastForkHeight()
    {
        return $this->last_fork_height;
    }

    /**
     * Optional The current height of the latest fork to the blockchain;
     * when no competing blockchain fork present, not returned with endpoints that return Blockchains.
     *
     * @param int $last_fork_height
     */
    public function setLastForkHeight($last_fork_height)
    {
        $this->last_fork_height = $last_fork_height;
    }

    /**
     * Optional The hash of the latest confirmed block in the latest fork of the blockchain;
     * when no competing blockchain fork present, not returned with endpoints that return Blockchains.
     *
     * @return string
     */
    public function getLastForkHash()
    {
        return $this->last_fork_hash;
    }

    /**
     * Optional The hash of the latest confirmed block in the latest fork of the blockchain;
     * when no competing blockchain fork present, not returned with endpoints that return Blockchains.
     *
     * @param string $last_fork_hash
     */
    public function setLastForkHash($last_fork_hash)
    {
        $this->last_fork_hash = $last_fork_hash;
    }
}