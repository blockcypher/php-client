<?php

namespace BlockCypher\Api;

use BlockCypher\Common\BlockCypherModel;

/**
 * Class Input
 *
 * Information about a single line item.
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
 * @property \BlockCypher\Api\RelatedResources[] related_resources
 */
class Input extends BlockCypherModel
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