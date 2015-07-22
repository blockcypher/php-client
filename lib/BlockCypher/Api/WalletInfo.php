<?php

namespace BlockCypher\Api;

use BlockCypher\Common\BlockCypherModel;

/**
 * Class WalletInfo
 *
 * @package BlockCypher\Api
 *
 * @property string token
 * @property string name
 * @property string[] addresses
 * @property bool hd
 */
class WalletInfo extends BlockCypherModel
{
    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

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
}