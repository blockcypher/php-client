<?php

namespace BlockCypher\Api;

use BlockCypher\Common\BlockCypherResourceModel;
use BlockCypher\Rest\ApiContext;
use BlockCypher\Transport\BlockCypherRestCall;
use BlockCypher\Validation\ArgumentGetParamsValidator;
use BlockCypher\Validation\ArgumentValidator;

/**
 * Class Chain
 *
 * A resource representing a block chain.
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
 */
class Chain extends BlockCypherResourceModel
{
    /**
     * Obtain the Bank Account resource for the given identifier.
     *
     * @param string $name
     * @param array $params Parameters
     * @param ApiContext $apiContext is the APIContext for this call. It can be used to pass dynamic configuration and credentials.
     * @param BlockCypherRestCall $restCall is the Rest Call Service that is used to make rest calls
     * @return Chain
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

        //Initialize the context if not provided explicitly
        $apiContext = $apiContext ? $apiContext : new ApiContext(self::$credential);
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
        $ret = new Chain();
        $ret->fromJson($json);
        return $ret;
    }

    /**
     * @return int
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * @param int $height
     * @return $this
     */
    public function setHeight($height)
    {
        $this->height = $height;
        return $this;
    }

    /**
     * @return string
     */
    public function getHash()
    {
        return $this->hash;
    }

    /**
     * @param string $hash
     * @return $this
     */
    public function setHash($hash)
    {
        $this->hash = $hash;
        return $this;
    }

    /**
     * @return string
     */
    public function getTime()
    {
        return $this->time;
    }

    /**
     * @param string $time
     * @return $this
     */
    public function setTime($time)
    {
        $this->time = $time;
        return $this;
    }

    /**
     * Hash of the latest block in the chain.
     *
     * @return string
     */
    public function getLatestUrl()
    {
        return $this->latest_url;
    }

    /**
     * Hash of the latest block in the chain.
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
     * Hash of the second to last block in the chain.
     *
     * @return string
     */
    public function getPreviousHash()
    {
        return $this->previous_hash;
    }

    /**
     * URL to retrieve information on the second to last block in the chain.
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
     * URL to retrieve information on the second to last block in the chain.
     *
     * @return string
     */
    public function getPreviousUrl()
    {
        return $this->previous_url;
    }

    /**
     * @param string $previous_url
     * @return $this
     */
    public function setPreviousUrl($previous_url)
    {
        $this->previous_url = $previous_url;
        return $this;
    }

    /**
     * @return int
     */
    public function getPeerCount()
    {
        return $this->peer_count;
    }

    /**
     * @param int $peer_count
     * @return $this
     */
    public function setPeerCount($peer_count)
    {
        $this->peer_count = $peer_count;
        return $this;
    }

    /**
     * @return int
     */
    public function getUnconfirmedCount()
    {
        return $this->unconfirmed_count;
    }

    /**
     * @param int $unconfirmed_count
     * @return $this
     */
    public function setUnconfirmedCount($unconfirmed_count)
    {
        $this->unconfirmed_count = $unconfirmed_count;
        return $this;
    }

    /**
     * Chain name.
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
     * Chain name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
}