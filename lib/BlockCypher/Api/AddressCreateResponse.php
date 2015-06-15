<?php

namespace BlockCypher\Api;

use BlockCypher\Common\BlockCypherResourceModel;

/**
 * Class AddressCreateResponse
 *
 * A resource representing an address generation response.
 *
 * @package BlockCypher\Api
 *
 * @property string private
 * @property string public
 * @property string address
 * @property string wif
 * @property string[] pubkeys
 * @property string script_type
 */
class AddressCreateResponse extends BlockCypherResourceModel
{
    /**
     * Public key.
     *
     * @return string
     */
    public function getPublic()
    {
        return $this->public;
    }

    /**
     * Public key.
     *
     * @param string $public
     * @return $this
     */
    public function setPublic($public)
    {
        $this->public = $public;
        return $this;
    }

    /**
     * Private key.
     *
     * @return string
     */
    public function getPrivate()
    {
        return $this->private;
    }

    /**
     * Private key.
     *
     * @param string $private
     * @return $this
     */
    public function setPrivate($private)
    {
        $this->private = $private;
        return $this;
    }

    /**
     * Wallet import format, a common encoding for the private key.
     *
     * @return string
     */
    public function getWif()
    {
        return $this->wif;
    }

    /**
     * Wallet import format, a common encoding for the private key.
     *
     * @param string $wif
     * @return $this
     */
    public function setWif($wif)
    {
        $this->wif = $wif;
        return $this;
    }

    /**
     * The newly generated address. Standard address representation.
     *
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * The newly generated address. Standard address representation.
     *
     * @param string $address
     * @return $this
     */
    public function setAddress($address)
    {
        $this->address = $address;
        return $this;
    }

    /**
     * Append Pubkey to the list.
     *
     * @param string $pubkey
     * @return $this
     */
    public function addPubkey($pubkey)
    {
        if (!$this->getPubkeys()) {
            return $this->setPubkeys(array($pubkey));
        } else {
            return $this->setPubkeys(
                array_merge($this->getPubkeys(), array($pubkey))
            );
        }
    }

    /**
     * @return \string[]
     */
    public function getPubkeys()
    {
        return $this->pubkeys;
    }

    /**
     * @param \string[] $pubkeys
     * @return $this
     */
    public function setPubkeys($pubkeys)
    {
        $this->pubkeys = $pubkeys;
    }

    /**
     * Remove Pubkey from the list.
     *
     * @param string $pubkey
     * @return $this
     */
    public function removePubkey($pubkey)
    {
        return $this->setPubkeys(
            array_diff($this->getPubkeys(), array($pubkey))
        );
    }

    /**
     * @return string
     */
    public function getScriptType()
    {
        return $this->script_type;
    }

    /**
     * @param string $script_type
     */
    public function setScriptType($script_type)
    {
        $this->script_type = $script_type;
    }
}