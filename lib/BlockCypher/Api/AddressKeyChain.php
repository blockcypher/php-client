<?php

namespace BlockCypher\Api;

use BlockCypher\Common\BlockCypherResourceModel;
use BlockCypher\Rest\ApiContext;
use BlockCypher\Transport\BlockCypherRestCall;

/**
 * Class AddressKeyChain
 *
 * An AddressKeychain represents an associated collection of public and private keys alongside
 * their respective public address. Generally returned and used with the Generate Address Endpoint.
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
class AddressKeyChain extends BlockCypherResourceModel
{
    /**
     * Create a new address.
     *
     * @param ApiContext $apiContext is the APIContext for this call. It can be used to pass dynamic configuration and credentials.
     * @param BlockCypherRestCall $restCall is the Rest Call Service that is used to make rest calls
     * @return AddressKeyChain
     */
    public function create($apiContext = null, $restCall = null)
    {
        $payLoad = $this->toJSON();

        $chainUrlPrefix = self::getChainUrlPrefix($apiContext);

        $json = self::executeCall(
            "$chainUrlPrefix/addrs",
            "POST",
            $payLoad,
            null,
            $apiContext,
            $restCall
        );
        $this->fromJson($json);
        return $this;
    }

    /**
     * Hex-encoded Public key.
     *
     * @return string
     */
    public function getPublic()
    {
        return $this->public;
    }

    /**
     * Hex-encoded Public key.
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
     * Hex-encoded Private key.
     *
     * @return string
     */
    public function getPrivate()
    {
        return $this->private;
    }

    /**
     * Hex-encoded Private key.
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
     * Standard address representation.
     *
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Standard address representation.
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
     * Optional Array of public keys to provide to generate a multisig address.
     *
     * @return \string[]
     */
    public function getPubkeys()
    {
        return $this->pubkeys;
    }

    /**
     * Optional Array of public keys to provide to generate a multisig address.
     *
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
     * Optional If generating a multisig address, the type of multisig script; typically “multisig-n-of-m”, where n and m are integers.
     *
     * @return string
     */
    public function getScriptType()
    {
        return $this->script_type;
    }

    /**
     * Optional If generating a multisig address, the type of multisig script; typically “multisig-n-of-m”, where n and m are integers.
     *
     * @param string $script_type
     * @return $this
     */
    public function setScriptType($script_type)
    {
        $this->script_type = $script_type;
    }
}