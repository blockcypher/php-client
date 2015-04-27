<?php

namespace BlockCypher\Api;

use BlockCypher\Common\BlockCypherResourceModel;
use BlockCypher\Rest\ApiContext;
use BlockCypher\Transport\BlockCypherRestCall;
use BlockCypher\Validation\ArgumentArrayValidator;
use BlockCypher\Validation\ArgumentGetParamsValidator;
use BlockCypher\Validation\ArgumentValidator;

/**
 * Class Chain
 *
 * A resource representing a block.
 *
 * @package BlockCypher\Api
 *
 * @property string hash
 * @property int height
 * @property string chain
 * @property int total
 * @property int fees
 * @property int ver
 * @property string time
 * @property string received_time
 * @property int bits
 * @property int nonce
 * @property int n_tx
 * @property string prev_block
 * @property string mrkl_root
 * @property string[] txids
 * @property int depth
 * @property string prev_block_url
 * @property string tx_url
 * @property string next_txids
 */
class Block extends BlockCypherResourceModel
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
    public static function get($hashOrHeight, $params = array(), $apiContext = null, $restCall = null)
    {
        ArgumentValidator::validate($hashOrHeight, 'hashOrHeight');
        ArgumentGetParamsValidator::validate($params, 'params');
        $allowedParams = array(
            'txstart' => 1,
            'limit' => 1,
        );
        $params = ArgumentGetParamsValidator::sanitize($params, $allowedParams);

        $payLoad = "";

        //Initialize the context if not provided explicitly
        $apiContext = $apiContext ? $apiContext : new ApiContext(self::$credential);
        $chainUrlPrefix = $apiContext->getBaseChainUrl();

        $json = self::executeCall(
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
    public static function getMultiple($array, $params = array(), $apiContext = null, $restCall = null)
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

        //Initialize the context if not provided explicitly
        $apiContext = $apiContext ? $apiContext : new ApiContext(self::$credential);
        $chainUrlPrefix = $apiContext->getBaseChainUrl();

        $json = self::executeCall(
            "$chainUrlPrefix/blocks/$blockList?" . http_build_query($params),
            "GET",
            $payLoad,
            null,
            $apiContext,
            $restCall
        );
        return Block::getList($json);
    }

    /**
     * The height of the block is the distance from the root of the chain, the genesis block at height = 0.
     *
     * @return int
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * The height of the block is the distance from the root of the chain, the genesis block at height = 0.
     *
     * @param int $height
     * @return $this
     */
    public function setHeight($height)
    {
        $this->height = $height;
        return $this;
    }

    /**
     * The name of the chain the block is from.
     *
     * @return string
     */
    public function getChain()
    {
        return $this->chain;
    }

    /**
     * The name of the chain the block is from.
     *
     * @param string $chain
     * @return $this
     */
    public function setChain($chain)
    {
        $this->chain = $chain;
        return $this;
    }

    /**
     * The total amount in satoshis transacted in this block. Divide by 10^8 to obtain the number of bitcoins.
     *
     * @return int
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * The total amount in satoshis transacted in this block. Divide by 10^8 to obtain the number of bitcoins.
     *
     * @param int $total
     * @return $this
     */
    public function setTotal($total)
    {
        $this->total = $total;
        return $this;
    }

    /**
     * Amount of fees, in satoshis, collected by miners on this block.
     *
     * @return int
     */
    public function getFees()
    {
        return $this->fees;
    }

    /**
     * Amount of fees, in satoshis, collected by miners on this block.
     *
     * @param int $fees
     * @return $this
     */
    public function setFees($fees)
    {
        $this->fees = $fees;
        return $this;
    }

    /**
     * @return int
     */
    public function getVer()
    {
        return $this->ver;
    }

    /**
     * @param int $ver
     * @return $this
     */
    public function setVer($ver)
    {
        $this->ver = $ver;
        return $this;
    }

    /**
     * Recorded time at which the block was built. (Note: miners rarely post accurate clock times).
     *
     * @return string
     */
    public function getTime()
    {
        return $this->time;
    }

    /**
     * Recorded time at which the block was built. (Note: miners rarely post accurate clock times).
     *
     * @param string $time
     * @return $this
     */
    public function setTime($time)
    {
        $this->time = $time;
        return $this;
    }

    /**
     * The time BlockCypher's servers receive the block. Our servers' time is continuously adjusted and accurate.
     *
     * @return string
     */
    public function getReceivedTime()
    {
        return $this->received_time;
    }

    /**
     * The time BlockCypher's servers receive the block. Our servers' time is continuously adjusted and accurate.
     *
     * @param string $received_time
     * @return $this
     */
    public function setReceivedTime($received_time)
    {
        $this->received_time = $received_time;
        return $this;
    }

    /**
     * The block-encoded difficulty target, for more information see https://en.bitcoin.it/wiki/Difficulty
     *
     * @return int
     */
    public function getBits()
    {
        return $this->bits;
    }

    /**
     * The block-encoded difficulty target, for more information see https://en.bitcoin.it/wiki/Difficulty
     *
     * @param int $bits
     * @return $this
     */
    public function setBits($bits)
    {
        $this->bits = $bits;
        return $this;
    }

    /**
     * Number used to generate this block. Incremented by miners to allow variation in the header (and hence its hash).
     *
     * @return int
     */
    public function getNonce()
    {
        return $this->nonce;
    }

    /**
     * Number used to generate this block. Incremented by miners to allow variation in the header (and hence its hash).
     *
     * @param int $nonce
     * @return $this
     */
    public function setNonce($nonce)
    {
        $this->nonce = $nonce;
        return $this;
    }

    /**
     * Number of transactions in this block.
     *
     * @return int
     */
    public function getNTx()
    {
        return $this->n_tx;
    }

    /**
     * Number of transactions in this block.
     *
     * @param int $n_tx
     * @return $this
     */
    public function setNTx($n_tx)
    {
        $this->n_tx = $n_tx;
        return $this;
    }

    /**
     * Hash of the block previous to this one.
     *
     * @return string
     */
    public function getPrevBlock()
    {
        return $this->prev_block;
    }

    /**
     * Hash of the block previous to this one.
     *
     * @param string $prev_block
     * @return $this
     */
    public function setPrevBlock($prev_block)
    {
        $this->prev_block = $prev_block;
        return $this;
    }

    /**
     * TODO: not documented in API reference site.
     *
     * @return string
     */
    public function getMrklRoot()
    {
        return $this->mrkl_root;
    }

    /**
     * TODO: not documented in API reference site.
     *
     * @param string $mrkl_root
     * @return $this
     */
    public function setMrklRoot($mrkl_root)
    {
        $this->mrkl_root = $mrkl_root;
        return $this;
    }

    /**
     * Array of transaction hashes included in this block. By default, we only return the 20 first transactions.
     * To obtain more, use the next_txids URL or the txstart and limit url query string parameters.
     *
     * @return \string[]
     */
    public function getTxids()
    {
        return $this->txids;
    }

    /**
     * Array of transaction hashes included in this block. By default, we only return the 20 first transactions.
     * To obtain more, use the next_txids URL or the txstart and limit url query string parameters.
     *
     * @param \string[] $txids
     * @return $this
     */
    public function setTxids($txids)
    {
        $this->txids = $txids;
        return $this;
    }

    /**
     * The depth is the distance from the latest block in the chain, or how many blocks have been found after this one.
     *
     * @return int
     */
    public function getDepth()
    {
        return $this->depth;
    }

    /**
     * The depth is the distance from the latest block in the chain, or how many blocks have been found after this one.
     *
     * @param int $depth
     * @return $this
     */
    public function setDepth($depth)
    {
        $this->depth = $depth;
        return $this;
    }

    /**
     * URL for the previous block's details.
     *
     * @return string
     */
    public function getPrevBlockUrl()
    {
        return $this->prev_block_url;
    }

    /**
     * URL for the previous block's details.
     *
     * @param string $prev_block_url
     * @return $this
     */
    public function setPrevBlockUrl($prev_block_url)
    {
        $this->prev_block_url = $prev_block_url;
        return $this;
    }

    /**
     * To retrieve base URL transactions. To get the full URL, concatenate this URL with the transaction's hash.
     *
     * @return string
     */
    public function getTxUrl()
    {
        return $this->tx_url;
    }

    /**
     * To retrieve base URL transactions. To get the full URL, concatenate this URL with the transaction's hash.
     *
     * @param string $tx_url
     * @return $this
     */
    public function setTxUrl($tx_url)
    {
        $this->tx_url = $tx_url;
        return $this;
    }

    /**
     * URL to get the same block information with the next 20 transactions.
     *
     * @return string
     */
    public function getNextTxids()
    {
        return $this->next_txids;
    }

    /**
     * URL to get the same block information with the next 20 transactions.
     *
     * @param string $next_txids
     * @return $this
     */
    public function setNextTxids($next_txids)
    {
        $this->next_txids = $next_txids;
        return $this;
    }

    /**
     * Block hash. Can be used as a unique identifier.
     *
     * @param $hash
     * @return $this
     */
    public function setHash($hash)
    {
        $this->hash = $hash;
        return $this;
    }

    /**
     * Block hash. Can be used as a unique identifier.
     *
     * @return string
     */
    public function getHash()
    {
        return $this->hash;
    }
}