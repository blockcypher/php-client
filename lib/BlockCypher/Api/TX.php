<?php

namespace BlockCypher\Api;

use BlockCypher\Common\BlockCypherResourceModel;
use BlockCypher\Rest\ApiContext;
use BlockCypher\Transport\BlockCypherRestCall;
use BlockCypher\Validation\ArgumentArrayValidator;
use BlockCypher\Validation\ArgumentGetParamsValidator;
use BlockCypher\Validation\ArgumentValidator;
use BlockCypher\Validation\UrlValidator;

/**
 * Class TX
 *
 * A TX represents the current state of a particular transaction from either a Block within a Blockchain,
 * or an unconfirmed transaction that has yet to be included in a Block. Typically returned from the
 * Unconfirmed Transactions and Transaction Hash endpoints.
 *
 * @package BlockCypher\Api
 *
 * @property string block_hash
 * @property int block_height
 * @property string hash
 * @property string[] addresses
 * @property int total
 * @property int fees
 * @property int size
 * @property string hex
 * @property string preference
 * @property string relayed_by
 * @property string confirmed
 * @property string received
 * @property int ver
 * @property int lock_time
 * @property bool double_spend
 * @property string double_spend_tx
 * @property string double_of
 * @property int receive_count
 * @property int vin_sz
 * @property int vout_sz
 * @property int confirmations
 * @property int confidence
 * @property int guaranteed
 * @property \BlockCypher\Api\TXInput[] inputs
 * @property \BlockCypher\Api\TXOutput[] outputs
 * @property string next_inputs
 * @property string next_outputs
 */
class TX extends BlockCypherResourceModel
{
    /**
     * Obtain the TX resource for the given identifier.
     *
     * @deprecated since version 1.2. Use TXClient.
     * @param string $hash
     * @param array $params Parameters. Options: instart, outstart and limit
     * @param ApiContext $apiContext is the APIContext for this call. It can be used to pass dynamic configuration and credentials.
     * @param BlockCypherRestCall $restCall is the Rest Call Service that is used to make rest calls
     * @return TX
     */
    public static function get($hash, $params = array(), $apiContext = null, $restCall = null)
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

        $chainUrlPrefix = self::getChainUrlPrefix($apiContext);

        $json = self::executeCall(
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
     * @deprecated since version 1.2. Use TXClient.
     * @param string[] $array
     * @param array $params Parameters. Options: instart, outstart and limit
     * @param ApiContext $apiContext is the APIContext for this call. It can be used to pass dynamic configuration and credentials.
     * @param BlockCypherRestCall $restCall is the Rest Call Service that is used to make rest calls
     * @return TX[]
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

        $chainUrlPrefix = self::getChainUrlPrefix($apiContext);

        $json = self::executeCall(
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
     * @deprecated since version 1.2. Use TXClient.
     * @param array $params Parameters. Options: instart, outstart and limit
     * @param ApiContext $apiContext is the APIContext for this call. It can be used to pass dynamic configuration and credentials.
     * @param BlockCypherRestCall $restCall is the Rest Call Service that is used to make rest calls
     * @return TX[]
     */
    public static function getUnconfirmed($params = array(), $apiContext = null, $restCall = null)
    {
        ArgumentGetParamsValidator::validate($params, 'params');
        $allowedParams = array();
        $params = ArgumentGetParamsValidator::sanitize($params, $allowedParams);

        $payLoad = "";

        $chainUrlPrefix = self::getChainUrlPrefix($apiContext);

        $json = self::executeCall(
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
     * @deprecated since version 1.2. Use TXClient.
     * @param string $hexRawTx
     * @param array $params Parameters. Options: instart, outstart and limit
     * @param ApiContext $apiContext is the APIContext for this call. It can be used to pass dynamic configuration and credentials.
     * @param BlockCypherRestCall $restCall is the Rest Call Service that is used to make rest calls
     * @return TX
     */
    public static function decode($hexRawTx, $params = array(), $apiContext = null, $restCall = null)
    {
        ArgumentValidator::validate($hexRawTx, 'hexRawTx');
        ArgumentGetParamsValidator::validate($params, 'params');
        $allowedParams = array();
        $params = ArgumentGetParamsValidator::sanitize($params, $allowedParams);

        $txHex = new TXHex();
        $txHex->setTx($hexRawTx);
        $payLoad = $txHex->toJSON();

        $chainUrlPrefix = self::getChainUrlPrefix($apiContext);

        $json = self::executeCall(
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
     * @deprecated since version 1.2. Use TXClient.
     * @param string $hexRawTx
     * @param array $params Parameters. Options: instart, outstart and limit
     * @param ApiContext $apiContext is the APIContext for this call. It can be used to pass dynamic configuration and credentials.
     * @param BlockCypherRestCall $restCall is the Rest Call Service that is used to make rest calls
     * @return TX
     */
    public static function push($hexRawTx, $params = array(), $apiContext = null, $restCall = null)
    {
        ArgumentValidator::validate($hexRawTx, 'hexRawTx');
        ArgumentGetParamsValidator::validate($params, 'params');
        $allowedParams = array();
        $params = ArgumentGetParamsValidator::sanitize($params, $allowedParams);

        $txHex = new TXHex();
        $txHex->setTx($hexRawTx);
        $payLoad = $txHex->toJSON();

        $chainUrlPrefix = self::getChainUrlPrefix($apiContext);

        $json = self::executeCall(
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
     * @deprecated since version 1.2. Use TXClient.
     * @param ApiContext $apiContext is the APIContext for this call. It can be used to pass dynamic configuration and credentials.
     * @param BlockCypherRestCall $restCall is the Rest Call Service that is used to make rest calls
     * @return TXSkeleton
     */
    public function create($apiContext = null, $restCall = null)
    {
        $payLoad = $this->toJSON();

        $chainUrlPrefix = self::getChainUrlPrefix($apiContext);

        $json = self::executeCall(
            "$chainUrlPrefix/txs/new",
            "POST",
            $payLoad,
            null,
            $apiContext,
            $restCall
        );
        $ret = new TXSkeleton();
        $ret->fromJson($json);
        return $ret;
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
     * @return string
     */
    public function getDoubleSpendTx()
    {
        return $this->double_spend_tx;
    }

    /**
     * @param string $double_spend_tx
     * @return $this
     */
    public function setDoubleSpendTx($double_spend_tx)
    {
        $this->double_spend_tx = $double_spend_tx;
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
     * TODO: missing description in docs site.
     *
     * @return boolean
     */
    public function isGuaranteed()
    {
        return $this->guaranteed;
    }

    /**
     * TODO: missing description in docs site.
     *
     * @return boolean
     */
    public function getGuaranteed()
    {
        return $this->guaranteed;
    }

    /**
     * TODO: missing description in docs site.
     *
     * @param boolean $guaranteed
     * @return $this
     */
    public function setGuaranteed($guaranteed)
    {
        $this->guaranteed = $guaranteed;
        return $this;
    }

    /**
     * Append TXInput to the list.
     *
     * @param \BlockCypher\Api\TXInput $input
     * @return \BlockCypher\Api\TXInput[]
     */
    public function addInput($input)
    {
        if (!$this->getInputs()) {
            return $this->setInputs(array($input));
        } else {
            return $this->setInputs(
                array_merge($this->getInputs(), array($input))
            );
        }
    }

    /**
     * Array of inputs, limited to 20. Use paging to get more inputs (see section on blocks) with
     * instart and limit URL parameters.
     *
     * @return \BlockCypher\Api\TXInput[]
     */
    public function getInputs()
    {
        return $this->inputs;
    }

    /**
     * Array of inputs, limited to 20. Use paging to get more inputs (see section on blocks) with
     * instart and limit URL parameters.
     *
     * @param \BlockCypher\Api\TXInput[] $inputs
     * @return $this
     */
    public function setInputs($inputs)
    {
        $this->inputs = $inputs;
        return $this;
    }

    /**
     * Remove TXInput from the list.
     *
     * @param \BlockCypher\Api\TXInput $input
     * @return \BlockCypher\Api\TXInput[]
     */
    public function removeInput($input)
    {
        return $this->setInputs(
            array_diff($this->getInputs(), array($input))
        );
    }

    /**
     * Append TXOutput to the list.
     *
     * @param \BlockCypher\Api\TXOutput $output
     * @return \BlockCypher\Api\TXOutput[]
     */
    public function addOutput($output)
    {
        if (!$this->getOutputs()) {
            return $this->setOutputs(array($output));
        } else {
            return $this->setOutputs(
                array_merge($this->getOutputs(), array($output))
            );
        }
    }

    /**
     * Array of outputs, limited to 20. Use paging to get more outputs (see section on blocks) with
     * outstart and limit URL parameters.
     *
     * @return \BlockCypher\Api\TXOutput[]
     */
    public function getOutputs()
    {
        return $this->outputs;
    }

    /**
     * Array of outputs, limited to 20. Use paging to get more outputs (see section on blocks) with
     * outstart and limit URL parameters.
     *
     * @param \BlockCypher\Api\TXOutput[] $outputs
     * @return $this
     */
    public function setOutputs($outputs)
    {
        $this->outputs = $outputs;
        return $this;
    }

    /**
     * Remove TXOutput from the list.
     *
     * @param \BlockCypher\Api\TXOutput $output
     * @return \BlockCypher\Api\TXOutput[]
     */
    public function removeOutput($output)
    {
        return $this->setOutputs(
            array_diff($this->getOutputs(), array($output))
        );
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

    /**
     * @return int
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * @param int $size
     */
    public function setSize($size)
    {
        $this->size = $size;
    }

    /**
     * @return string
     */
    public function getNextInputs()
    {
        return $this->next_inputs;
    }

    /**
     * @param string $next_inputs
     * @return $this
     */
    public function setNextInputs($next_inputs)
    {
        UrlValidator::validate($next_inputs, "next_inputs");
        $this->next_inputs = $next_inputs;
        return $this;
    }

    /**
     * @return string
     */
    public function getNextOutputs()
    {
        return $this->next_outputs;
    }

    /**
     * @param string $next_outputs
     * @return $this
     */
    public function setNextOutputs($next_outputs)
    {
        UrlValidator::validate($next_outputs, "next_outputs");
        $this->next_outputs = $next_outputs;
        return $this;
    }
}