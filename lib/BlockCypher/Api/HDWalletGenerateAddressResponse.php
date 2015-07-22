<?php

namespace BlockCypher\Api;

use BlockCypher\Common\BlockCypherBaseModel;

/**
 * Class HDWalletGenerateAddressResponse
 *
 * A resource representing an HD wallet address generation response.
 *
 * @package BlockCypher\Api
 *
 * @property string token
 * @property string name
 * @property string[] addresses
 * @property bool hd
 * @property int subchain_index
 * @property string address
 * @property string public
 */
class HDWalletGenerateAddressResponse extends BlockCypherBaseModel
{
    /**
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @param string $token
     * @return $this
     */
    public function setToken($token)
    {
        $this->token = $token;
        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;
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
     * @return \string[]
     */
    public function getAddresses()
    {
        return $this->addresses;
    }

    /**
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
     * @return boolean
     */
    public function isHd()
    {
        return $this->hd;
    }

    /**
     * @return bool
     */
    public function getHd()
    {
        return $this->hd;
    }

    /**
     * @param boolean $hd
     * @return $this
     */
    public function setHd($hd)
    {
        $this->hd = $hd;
        return $this;
    }

    /**
     * @return int
     */
    public function getSubchainIndex()
    {
        return $this->subchain_index;
    }

    /**
     * @param int $subchain_index
     * @return $this
     */
    public function setSubchainIndex($subchain_index)
    {
        $this->subchain_index = $subchain_index;
        return $this;
    }

    /**
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param string $address
     * @return $this
     */
    public function setAddress($address)
    {
        $this->address = $address;
        return $this;
    }

    /**
     * @return string
     */
    public function getPublic()
    {
        return $this->public;
    }

    /**
     * @param string $public
     * @return $this
     */
    public function setPublic($public)
    {
        $this->public = $public;
        return $this;
    }
}