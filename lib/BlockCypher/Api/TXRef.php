<?php

namespace BlockCypher\Api;

use BlockCypher\Common\BlockCypherBaseModel;

/**
 * Class TXRef
 *
 * A TXRef object represents summarized data about a transaction input or output. Typically found in an array
 * within an Address object, which is usually returned from the standard Address Endpoint.
 *
 * @package BlockCypher\Api
 *
 * @property string address Only present when parent object represents a wallet
 * @property string tx_hash
 * @property int block_height
 * @property int tx_input_n
 * @property int tx_output_n
 * @property int value
 * @property int ref_balance
 * @property string preference
 * @property bool spent
 * @property string spent_by
 * @property int confirmations
 * @property string confirmed
 * @property string received
 * @property bool double_spend
 * @property string double_of
 * @property int receive_count
 * @property float confidence
 */
class TXRef extends BlockCypherBaseModel
{
    /**
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param string $address
     */
    public function setAddress($address)
    {
        $this->address = $address;
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
     * Unconfirmed transactions only. Confidence this transaction will be confirmed (see Zero Confirmations).
     *
     * @return float
     */
    public function getConfidence()
    {
        return $this->confidence;
    }

    /**
     * Unconfirmed transactions only. Confidence this transaction will be confirmed (see Zero Confirmations).
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
     * Whether the transaction is a double spend (see Zero Confirmations).
     *
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
     * One of the transaction hashes for the specified address.
     *
     * @return string
     */
    public function getTxHash()
    {
        return $this->tx_hash;
    }

    /**
     * One of the transaction hashes for the specified address.
     *
     * @param string $tx_hash
     * @return $this
     */
    public function setTxHash($tx_hash)
    {
        $this->tx_hash = $tx_hash;
        return $this;
    }

    /**
     * Height of the block for the transaction.
     *
     * @return int
     */
    public function getBlockHeight()
    {
        return $this->block_height;
    }

    /**
     * Height of the block for the transaction.
     *
     * @param int $block_height
     * @return $this
     */
    public function setBlockHeight($block_height)
    {
        $this->block_height = $block_height;
        return $this;
    }

    /**
     * Index of the input in the transaction. It's a negative number for an output.
     *
     * @return int
     */
    public function getTxInputN()
    {
        return $this->tx_input_n;
    }

    /**
     * Index of the input in the transaction. It's a negative number for an output.
     *
     * @param int $tx_input_n
     * @return $this
     */
    public function setTxInputN($tx_input_n)
    {
        $this->tx_input_n = $tx_input_n;
        return $this;
    }

    /**
     * Index of the output in the transaction. It's a negative number for an input.
     *
     * @return int
     */
    public function getTxOutputN()
    {
        return $this->tx_output_n;
    }

    /**
     * Index of the output in the transaction. It's a negative number for an input.
     *
     * @param int $tx_output_n
     * @return $this
     */
    public function setTxOutputN($tx_output_n)
    {
        $this->tx_output_n = $tx_output_n;
        return $this;
    }

    /**
     * The value transferred by the particular input or output.
     *
     * @return int
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * The value transferred by the particular input or output.
     *
     * @param int $value
     * @return $this
     */
    public function setValue($value)
    {
        $this->value = $value;
        return $this;
    }

    /**
     * Optional The past balance of the parent address the moment this transaction was confirmed.
     * Not present for unconfirmed transactions.
     *
     * @return int
     */
    public function getRefBalance()
    {
        return $this->ref_balance;
    }

    /**
     * Optional The past balance of the parent address the moment this transaction was confirmed.
     * Not present for unconfirmed transactions.
     *
     * @param int $ref_balance
     * @return $this
     */
    public function setRefBalance($ref_balance)
    {
        $this->ref_balance = $ref_balance;
        return $this;
    }

    /**
     * @return string
     */
    public function getPreference()
    {
        return $this->preference;
    }

    /**
     * @param string $preference
     * @return $this
     */
    public function setPreference($preference)
    {
        $this->preference = $preference;
        return $this;
    }

    /**
     * Is 'true' if the output was spent.
     *
     * @return boolean
     */
    public function isSpent()
    {
        return $this->spent;
    }

    /**
     * Is 'true' if the output was spent.
     *
     * @return boolean
     */
    public function getSpent()
    {
        return $this->spent;
    }

    /**
     * Is 'true' if the output was spent.
     *
     * @param boolean $spent
     * @return $this
     */
    public function setSpent($spent)
    {
        $this->spent = $spent;
        return $this;
    }

    /**
     * @return string
     */
    public function getSpentBy()
    {
        return $this->spent_by;
    }

    /**
     * @param string $spent_by
     * @return $this
     */
    public function setSpentBy($spent_by)
    {
        $this->spent_by = $spent_by;
        return $this;
    }

    /**
     * Number of confirmations for the transaction.
     *
     * @return int
     */
    public function getConfirmations()
    {
        return $this->confirmations;
    }

    /**
     * Number of confirmations for the transaction.
     *
     * @param int $confirmations
     * @return $this
     */
    public function setConfirmations($confirmations)
    {
        $this->confirmations = $confirmations;
        return $this;
    }
}