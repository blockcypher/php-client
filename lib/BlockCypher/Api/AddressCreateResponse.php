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
}