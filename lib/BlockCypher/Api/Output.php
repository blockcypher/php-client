<?php

namespace BlockCypher\Api;

use BlockCypher\Common\BlockCypherBaseModel;

/**
 * Class Output
 *
 * Information about a single line item.
 *
 * script_type values:
 * pay-to-pubkey-hash (most common transaction transferring to a public key hash, and the default behavior if no out)
 * pay-to-multi-pubkey-hash (multi-signatures transaction, now actually less used than pay-to-script-hash for this purpose)
 * pay-to-pubkey (used for mining transactions)
 * pay-to-script-hash (used for transactions relying on arbitrary scripts, now used primarily for multi-sig transactions)
 * null-data (sometimes called op-return; used to embed small chunks of data in the blockchain)
 * empty (no script present, mostly used for mining transaction inputs)
 * unknown (non-standard script)
 *
 * @package BlockCypher\Api
 *
 * @property int value
 * @property string script
 * @property string spent_by
 * @property string[] addresses
 * @property string script_type
 */
class Output extends BlockCypherBaseModel
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