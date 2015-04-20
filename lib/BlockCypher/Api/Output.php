<?php

namespace BlockCypher\Api;

use BlockCypher\Common\BlockCypherModel;

/**
 * Class Output
 *
 * Information about a single line item.
 *
 * @package BlockCypher\Api
 *
 * @property int value
 * @property string script
 * @property string spent_by
 * @property string[] addresses
 * @property string script_type
 */
class Output extends BlockCypherModel
{
    /**
     * Value transferred by the transaction output, in satoshi.
     *
     * @return int
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Value transferred by the transaction output, in satoshi.
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
     * Hash of the transaction that spent this output, if it was spent.
     *
     * @return string
     */
    public function getSpentBy()
    {
        return $this->spent_by;
    }

    /**
     * Hash of the transaction that spent this output, if it was spent.
     *
     * @param string $spent_by
     * @return $this
     */
    public function setSpentBy($spent_by)
    {
        $this->spent_by = $spent_by;
        return $this;
    }

    /**
     * Addresses where the value is being transferred to.
     *
     * @return \string[]
     */
    public function getAddresses()
    {
        return $this->addresses;
    }

    /**
     * Addresses where the value is being transferred to.
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
     * Script type for this output.
     *
     * @return string
     */
    public function getScriptType()
    {
        return $this->script_type;
    }

    /**
     * Script type for this output.
     *
     * @param string $script_type
     * @return $this
     */
    public function setScriptType($script_type)
    {
        $this->script_type = $script_type;
        return $this;
    }
}