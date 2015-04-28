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
 * @property string block_hash
 * @property int block_height
 * @property string hash
 * @property string[] addresses
 * @property int total
 * @property int fees
 * @property string hex
 * @property string preference
 * @property string relayed_by
 * @property string confirmed
 * @property string received
 * @property int ver
 * @property int lock_time
 * @property bool double_spend
 * @property string double_of
 * @property int receive_count
 * @property int vin_sz
 * @property int vout_sz
 * @property int confirmations
 * @property int confidence
 * @property \BlockCypher\Api\Input[] inputs
 * @property \BlockCypher\Api\Output[] outputs
 */
class Transaction extends BlockCypherResourceModel
{
    /**
     * Obtain the Transaction resource for the given identifier.
     *
     * @param string $hash
     * @param array $params Parameters. Options: instart, outstart and limit
     * @param ApiContext $apiContext is the APIContext for this call. It can be used to pass dynamic configuration and credentials.
     * @param BlockCypherRestCall $restCall is the Rest Call Service that is used to make rest calls
     * @return Transaction
     */
    public static function get($hash, $params = array(), $apiContext = null, $restCall = null)
    {
        ArgumentValidator::validate($hash, 'hash');
        ArgumentGetParamsValidator::validate($params, 'params');
        $allowedParams = array(
            'instart' => 1,
            'outstart' => 1,
            'limit' => 1,
        );
        $params = ArgumentGetParamsValidator::sanitize($params, $allowedParams);

        $payLoad = "";

        //Initialize the context if not provided explicitly
        $apiContext = $apiContext ? $apiContext : new ApiContext(self::$credential);
        $chainUrlPrefix = $apiContext->getBaseChainUrl();

        $json = self::executeCall(
            "$chainUrlPrefix/txs/$hash?" . http_build_query($params),
            "GET",
            $payLoad,
            null,
            $apiContext,
            $restCall
        );
        $ret = new Transaction();
        $ret->fromJson($json);
        return $ret;
    }

    /**
     * Obtain multiple Transaction resources for the given identifier.
     *
     * @param string[] $array
     * @param array $params Parameters. Options: instart, outstart and limit
     * @param ApiContext $apiContext is the APIContext for this call. It can be used to pass dynamic configuration and credentials.
     * @param BlockCypherRestCall $restCall is the Rest Call Service that is used to make rest calls
     * @return Transaction[]
     */
    public static function getMultiple($array, $params = array(), $apiContext = null, $restCall = null)
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

        //Initialize the context if not provided explicitly
        $apiContext = $apiContext ? $apiContext : new ApiContext(self::$credential);
        $chainUrlPrefix = $apiContext->getBaseChainUrl();

        $json = self::executeCall(
            "$chainUrlPrefix/txs/$transactionList?" . http_build_query($params),
            "GET",
            $payLoad,
            null,
            $apiContext,
            $restCall
        );
        return Transaction::getList($json);
    }

    /**
     * Unconfirmed transactions only. The number of peers that have sent this transaction to us (see Zero Confirmations).
     *
     * @return int
     */
    public function getReceiveCount()
    {
        return $this->receive_count;
    }

    /**
     * Unconfirmed transactions only. The number of peers that have sent this transaction to us (see Zero Confirmations).
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
     * If the transaction is a double spend, what transaction it's double-spending (see Zero Confirmations).
     *
     * @return string
     */
    public function getDoubleOf()
    {
        return $this->double_of;
    }

    /**
     * If the transaction is a double spend, what transaction it's double-spending (see Zero Confirmations).
     *
     * @param string $double_of
     * @return $this
     */
    public function setDoubleOf($double_of)
    {
        $this->double_of = $double_of;
        return $this;
    }

    /**
     * Hex encoded bytes of the raw transaction (as sent over the network).
     * Only included when the includeHex URL property is set to true.
     *
     * @return string
     */
    public function getHex()
    {
        return $this->hex;
    }

    /**
     * Hex encoded bytes of the raw transaction (as sent over the network).
     * Only included when the includeHex URL property is set to true.
     *
     * @param string $hex
     * @return $this
     */
    public function setHex($hex)
    {
        $this->hex = $hex;
        return $this;
    }

    /**
     * Array of Bitcoin addresses involved in the transaction.
     *
     * @return \string[]
     */
    public function getAddresses()
    {
        return $this->addresses;
    }

    /**
     * Array of Bitcoin addresses involved in the transaction.
     *
     * @param \string[] $addresses
     * @return $this
     */
    public function setAddresses($addresses)
    {
        $this->addresses = $addresses;
        return $this;
    }

    /**
     * Total amount exchanged in this transaction, in satoshis.
     *
     * @return int
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * Total amount exchanged in this transaction, in satoshis.
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
     * How likely is this transaction to make it to the next block, reflects the preference level miners have to include
     * this transaction. Can be high, medium or low.
     *
     * @return string
     */
    public function getPreference()
    {
        return $this->preference;
    }

    /**
     * How likely is this transaction to make it to the next block, reflects the preference level miners have to include
     * this transaction. Can be high, medium or low.
     *
     * @param string $preference
     * @return $this
     */
    public function setPreference($preference)
    {
        $this->preference = $preference;
        return $this;
    }

    /**
     * Address of the peer that sent us this transaction.
     *
     * @return string
     */
    public function getRelayedBy()
    {
        return $this->relayed_by;
    }

    /**
     * Address of the peer that sent us this transaction.
     *
     * @param string $relayed_by
     * @return $this
     */
    public function setRelayedBy($relayed_by)
    {
        $this->relayed_by = $relayed_by;
        return $this;
    }

    /**
     * Date at which the transaction was included in a block, in ISO format.
     *
     * @return string
     */
    public function getConfirmed()
    {
        return $this->confirmed;
    }

    /**
     * Date at which the transaction was included in a block, in ISO format.
     *
     * @param string $confirmed
     * @return $this
     */
    public function setConfirmed($confirmed)
    {
        $this->confirmed = $confirmed;
        return $this;
    }

    /**
     * When the transaction was received by BlockCypher servers.
     *
     * @return string
     */
    public function getReceived()
    {
        return $this->received;
    }

    /**
     * When the transaction was received by BlockCypher servers.
     *
     * @param string $received
     * @return $this
     */
    public function setReceived($received)
    {
        $this->received = $received;
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
     * @return int
     */
    public function getLockTime()
    {
        return $this->lock_time;
    }

    /**
     * @param int $lock_time
     * @return $this
     */
    public function setLockTime($lock_time)
    {
        $this->lock_time = $lock_time;
        return $this;
    }

    /**
     * @return boolean
     */
    public function isDoubleSpend()
    {
        return $this->double_spend;
    }

    /**
     * Whether the transaction is a double spend (see Zero Confirmations).
     *
     * @return boolean
     */
    public function getDoubleSpend()
    {
        return $this->double_spend;
    }

    /**
     * Whether the transaction is a double spend (see Zero Confirmations).
     *
     * @param boolean $double_spend
     * @return $this
     */
    public function setDoubleSpend($double_spend)
    {
        $this->double_spend = $double_spend;
        return $this;
    }

    /**
     * Total number of inputs
     *
     * @return int
     */
    public function getVinSz()
    {
        return $this->vin_sz;
    }

    /**
     * Total number of inputs
     *
     * @param int $vin_sz
     * @return $this
     */
    public function setVinSz($vin_sz)
    {
        $this->vin_sz = $vin_sz;
        return $this;
    }

    /**
     * Total number of outputs
     *
     * @return int
     */
    public function getVoutSz()
    {
        return $this->vout_sz;
    }

    /**
     * Total number of outputs
     *
     * @param int $vout_sz
     * @return $this
     */
    public function setVoutSz($vout_sz)
    {
        $this->vout_sz = $vout_sz;
        return $this;
    }

    /**
     * Number of subsequent blocks, including the block the transaction is in. Unconfirmed transactions have 0 for confirmation.
     *
     * @return int
     */
    public function getConfirmations()
    {
        return $this->confirmations;
    }

    /**
     * Number of subsequent blocks, including the block the transaction is in. Unconfirmed transactions have 0 for confirmation.
     *
     * @param int $confirmations
     * @return $this
     */
    public function setConfirmations($confirmations)
    {
        $this->confirmations = $confirmations;
        return $this;
    }

    /**
     * Unconfirmed transactions only. Confidence this transaction will be confirmed (see Zero Confirmations).
     *
     * @return int
     */
    public function getConfidence()
    {
        return $this->confidence;
    }

    /**
     * Unconfirmed transactions only. Confidence this transaction will be confirmed (see Zero Confirmations).
     *
     * @param int $confidence
     * @return $this
     */
    public function setConfidence($confidence)
    {
        $this->confidence = $confidence;
        return $this;
    }

    /**
     * Array of inputs, limited to 20. Use paging to get more inputs (see section on blocks) with
     * instart and limit URL parameters.
     *
     * @return \BlockCypher\Api\Input[]
     */
    public function getInputs()
    {
        return $this->inputs;
    }

    /**
     * Array of inputs, limited to 20. Use paging to get more inputs (see section on blocks) with
     * instart and limit URL parameters.
     *
     * @param \BlockCypher\Api\Input[] $inputs
     * @return $this
     */
    public function setInputs($inputs)
    {
        $this->inputs = $inputs;
        return $this;
    }

    /**
     * Array of outputs, limited to 20. Use paging to get more outputs (see section on blocks) with
     * outstart and limit URL parameters.
     *
     * @return \BlockCypher\Api\Output[]
     */
    public function getOutputs()
    {
        return $this->outputs;
    }

    /**
     * Array of outputs, limited to 20. Use paging to get more outputs (see section on blocks) with
     * outstart and limit URL parameters.
     *
     * @param \BlockCypher\Api\Output[] $outputs
     * @return $this
     */
    public function setOutputs($outputs)
    {
        $this->outputs = $outputs;
        return $this;
    }

    /**
     * BlockHash of the block the transaction is in. Only exists for confirmed transactions.
     *
     * @param $block_hash
     * @return $this
     */
    public function setBlockHash($block_hash)
    {
        $this->block_hash = $block_hash;
        return $this;
    }

    /**
     * BlockHash of the block the transaction is in. Only exists for confirmed transactions.
     *
     * @return string
     */
    public function getBlockHash()
    {
        return $this->block_hash;
    }

    /**
     * Height of the block the transaction is in. Only exists for confirmed transactions.
     *
     * @param $block_height
     * @return $this
     */
    public function setBlockHeight($block_height)
    {
        $this->block_height = $block_height;
        return $this;
    }

    /**
     * Height of the block the transaction is in. Only exists for confirmed transactions.
     *
     * @return string
     */
    public function getBlockHeight()
    {
        return $this->block_height;
    }

    /**
     * Hash of the transaction. While hashes are reasonably unique, using them as identifiers may be unsafe.
     * https://en.bitcoin.it/wiki/Transaction_Malleability
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
     * Hash of the transaction. While hashes are reasonably unique, using them as identifiers may be unsafe.
     * https://en.bitcoin.it/wiki/Transaction_Malleability
     *
     * @return string
     */
    public function getHash()
    {
        return $this->hash;
    }

    /**
     * Fees collected by miners in the transaction, in satoshis.
     *
     * @param $fees
     * @return $this
     */
    public function setFees($fees)
    {
        $this->fees = $fees;
        return $this;
    }

    /**
     * Fees collected by miners in the transaction, in satoshis.
     *
     * @return int
     */
    public function getFees()
    {
        return $this->fees;
    }
}