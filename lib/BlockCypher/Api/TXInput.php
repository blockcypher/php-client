<?php

namespace BlockCypher\Api;

use BlockCypher\Common\BlockCypherBaseModel;

/**
 * Class TXInput
 *
 * A TXInput represents an input consumed within a transaction. Typically found within an array in a TX.
 * In most cases, TXInputs are from previous UTXOs, with the most prominent exceptions being attempted double-spend
 * and coinbase inputs.
 *
 * @package BlockCypher\Api
 *
 * @property string prev_hash
 * @property int output_index
 * @property string script
 * @property int output_value
 * @property int age
 * @property int sequence
 * @property string[] addresses
 * @property string script_type
 * @property string wallet_name
 * @property string wallet_token
 * @property \BlockCypher\Api\RelatedResources[] related_resources
 */
class TXInput extends BlockCypherBaseModel
{
    /**
     * Number of confirmations since the transaction referenced by this input was included in the blockchain.
     * Only present for unconfirmed transactions for now.
     *
     * @return int
     */
    public function getAge()
    {
        return $this->age;
    }

    /**
     * Number of confirmations since the transaction referenced by this input was included in the blockchain.
     * Only present for unconfirmed transactions for now.
     *
     * @param int $age
     * @return $this
     */
    public function setAge($age)
    {
        $this->age = $age;
        return $this;
    }

    /**
     * Hash of the transaction for which an output is being spent by this input. Does not exist for coinbase transactions.
     *
     * @return string
     */
    public function getPrevHash()
    {
        return $this->prev_hash;
    }

    /**
     * Hash of the transaction for which an output is being spent by this input. Does not exist for coinbase transactions.
     *
     * @param string $prev_hash
     * @return $this
     */
    public function setPrevHash($prev_hash)
    {
        $this->prev_hash = $prev_hash;
        return $this;
    }

    /**
     * Index in the previous transaction of the output being spent. Does not exist for coinbase transactions.
     *
     * @return int
     */
    public function getOutputIndex()
    {
        return $this->output_index;
    }

    /**
     * Index in the previous transaction of the output being spent. Does not exist for coinbase transactions.
     *
     * @param int $output_index
     * @return $this
     */
    public function setOutputIndex($output_index)
    {
        $this->output_index = $output_index;
        return $this;
    }

    /**
     * Raw hexadecimal encoding of the script.
     *
     * @return string
     */
    public function getScript()
    {
        return $this->script;
    }

    /**
     * Raw hexadecimal encoding of the script.
     *
     * @param string $script
     * @return $this
     */
    public function setScript($script)
    {
        $this->script = $script;
        return $this;
    }

    /**
     * Value of the output being spent. Does not exist for coinbase transactions.
     *
     * @return int
     */
    public function getOutputValue()
    {
        return $this->output_value;
    }

    /**
     * Value of the output being spent. Does not exist for coinbase transactions.
     *
     * @param int $output_value
     * @return $this
     */
    public function setOutputValue($output_value)
    {
        $this->output_value = $output_value;
        return $this;
    }

    /**
     * @return int
     */
    public function getSequence()
    {
        return $this->sequence;
    }

    /**
     * @param int $sequence
     * @return $this
     */
    public function setSequence($sequence)
    {
        $this->sequence = $sequence;
        return $this;
    }

    /**
     * Append Address to the list.
     *
     * @param string $address
     * @return $this
     */
    public function addAddress($address)
    {
        if (!$this->getAddresses()) {
            return $this->setAddresses(array($address));
        } else {
            return $this->setAddresses(
                array_merge($this->getAddresses(), array($address))
            );
        }
    }

    /**
     * Addresses referenced in the transaction output being spent.
     *
     * @return \string[]
     */
    public function getAddresses()
    {
        return $this->addresses;
    }

    /**
     * Addresses referenced in the transaction output being spent.
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
     * Remove Address from the list.
     *
     * @param string $address
     * @return $this
     */
    public function removeAddress($address)
    {
        return $this->setAddresses(
            array_diff($this->getAddresses(), array($address))
        );
    }

    /**
     * Script type in the transaction output being spent.
     *
     * @return string
     */
    public function getScriptType()
    {
        return $this->script_type;
    }

    /**
     * Script type in the transaction output being spent.
     *
     * @param string $script_type
     * @return $this
     */
    public function setScriptType($script_type)
    {
        $this->script_type = $script_type;
        return $this;
    }

    /**
     * @return string
     */
    public function getWalletName()
    {
        return $this->wallet_name;
    }

    /**
     * @param string $wallet_name
     * @return $this
     */
    public function setWalletName($wallet_name)
    {
        $this->wallet_name = $wallet_name;
        return $this;
    }

    /**
     * @return string
     */
    public function getWalletToken()
    {
        return $this->wallet_token;
    }

    /**
     * @param string $wallet_token
     * @return $this
     */
    public function setWalletToken($wallet_token)
    {
        $this->wallet_token = $wallet_token;
        return $this;
    }

    /**
     * @return \BlockCypher\Api\RelatedResources[]
     */
    public function getRelatedResources()
    {
        return $this->related_resources;
    }

    /**
     * @param \BlockCypher\Api\RelatedResources[] $related_resources
     * @return $this
     */
    public function setRelatedResources($related_resources)
    {
        $this->related_resources = $related_resources;
        return $this;
    }
}