<?php

namespace BlockCypher\Api;

use BlockCypher\Common\BlockCypherResourceModel;
use BlockCypher\Rest\ApiContext;
use BlockCypher\Transport\BlockCypherRestCall;
use BlockCypher\Validation\ArgumentArrayValidator;
use BlockCypher\Validation\ArgumentGetParamsValidator;
use BlockCypher\Validation\ArgumentValidator;

/**
 * Class Block
 *
 * A Block represents the current state of a particular block from a Blockchain.
 * Typically returned from the Block Hash and Block Height endpoints.
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
     * @deprecated since version 1.2. Use BlockClient.
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

        $chainUrlPrefix = self::getChainUrlPrefix($apiContext);

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
     * @deprecated since version 1.2. Use BlockClient.
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

        $chainUrlPrefix = self::getChainUrlPrefix($apiContext);

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
     * The height of the block in the blockchain; i.e., there are height earlier blocks in its blockchain.
     *
     * @return int
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * The height of the block in the blockchain; i.e., there are height earlier blocks in its blockchain.
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
     * The name of the blockchain represented, in the form of $COIN.$CHAIN
     *
     * @return string
     */
    public function getChain()
    {
        return $this->chain;
    }

    /**
     * The name of the blockchain represented, in the form of $COIN.$CHAIN
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
     * The total number of satoshis transacted in this block.
     *
     * @return int
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * The total number of satoshis transacted in this block.
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
     * The total number of fees—in satoshis—collected by miners in this block.
     *
     * @return int
     */
    public function getFees()
    {
        return $this->fees;
    }

    /**
     * The total number of fees—in satoshis—collected by miners in this block.
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
     * Block version. In Bitcoin, per BIP34 the last version 1 block was at height 227835.
     *
     * @return int
     */
    public function getVer()
    {
        return $this->ver;
    }

    /**
     * Block version. In Bitcoin, per BIP34 the last version 1 block was at height 227835.
     *
     * @param int $ver
     * @return $this
     */
    public function setVer($ver)
    {
        $this->ver = $ver;
        return $this;
    }

    /**
     * Recorded time at which block was built. Note: Miners rarely post accurate clock times.
     *
     * @return string
     */
    public function getTime()
    {
        return $this->time;
    }

    /**
     * Recorded time at which block was built. Note: Miners rarely post accurate clock times.
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
     * The time BlockCypher’s servers receive the block. Our servers’ clock is continuously adjusted and accurate.
     *
     * @return string
     */
    public function getReceivedTime()
    {
        return $this->received_time;
    }

    /**
     * The time BlockCypher’s servers receive the block. Our servers’ clock is continuously adjusted and accurate.
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
     * The block-encoded difficulty target.
     *
     * @return int
     */
    public function getBits()
    {
        return $this->bits;
    }

    /**
     * The block-encoded difficulty target.
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
     * The number used by a miner to generate this block.
     *
     * @return int
     */
    public function getNonce()
    {
        return $this->nonce;
    }

    /**
     * The number used by a miner to generate this block.
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
     * The Merkle root of this block.
     * https://bitcoin.stackexchange.com/questions/10479/what-is-the-merkle-root
     *
     * @return string
     */
    public function getMrklRoot()
    {
        return $this->mrkl_root;
    }

    /**
     * The Merkle root of this block.
     * https://bitcoin.stackexchange.com/questions/10479/what-is-the-merkle-root
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
     * An array of transaction hashes in this block. By default, only 20 are included.
     *
     * @return \string[]
     */
    public function getTxids()
    {
        return $this->txids;
    }

    /**
     * An array of transaction hashes in this block. By default, only 20 are included.
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
     * The depth of the block in the blockchain; i.e., there are depth later blocks in its blockchain.
     *
     * @return int
     */
    public function getDepth()
    {
        return $this->depth;
    }

    /**
     * The depth of the block in the blockchain; i.e., there are depth later blocks in its blockchain.
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
     * The BlockCypher URL to query for more information on the previous block.
     *
     * @return string
     */
    public function getPrevBlockUrl()
    {
        return $this->prev_block_url;
    }

    /**
     * The BlockCypher URL to query for more information on the previous block.
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
     * The base BlockCypher URL to receive transaction details. To get more details about specific transactions,
     * you must concatenate this URL with the desired transaction hash(es).
     *
     * @return string
     */
    public function getTxUrl()
    {
        return $this->tx_url;
    }

    /**
     * The base BlockCypher URL to receive transaction details. To get more details about specific transactions,
     * you must concatenate this URL with the desired transaction hash(es).
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
     * Optional If there are more transactions that couldn’t fit in the txids array,
     * this is the BlockCypher URL to query the next set of transactions (within a Block object).
     *
     * @return string
     */
    public function getNextTxids()
    {
        return $this->next_txids;
    }

    /**
     * Optional If there are more transactions that couldn’t fit in the txids array,
     * this is the BlockCypher URL to query the next set of transactions (within a Block object).
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
     * The hash of the block; in Bitcoin, the hashing function is SHA256(SHA256(block))
     *
     * @return string
     */
    public function getHash()
    {
        return $this->hash;
    }

    /**
     * The hash of the block; in Bitcoin, the hashing function is SHA256(SHA256(block))
     *
     * @param $hash
     * @return $this
     */
    public function setHash($hash)
    {
        $this->hash = $hash;
        return $this;
    }
}