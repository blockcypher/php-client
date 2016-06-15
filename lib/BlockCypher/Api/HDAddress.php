<?php

namespace BlockCypher\Api;

use BlockCypher\Common\BlockCypherBaseModel;

/**
 * Class HDAddress
 *
 * An HD Address object contains an address and its BIP32 HD path (location of the address in the HD tree).
 * It also contains the hex-encoded public key when returned from the Derive Address in Wallet endpoint.
 *
 * @package BlockCypher\Api
 *
 * @property string address
 * @property string path
 * @property string public
 */
class HDAddress extends BlockCypherBaseModel
{
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
     * The BIP32 path of the HD address.
     *
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * The BIP32 path of the HD address.
     *
     * @param string $path
     * @return $this
     */
    public function setPath($path)
    {
        $this->path = $path;
        return $this;
    }

    /**
     * Contains the hex-encoded public key if returned by Derive Address in Wallet endpoint. Optional.
     *
     * @return string
     */
    public function getPublic()
    {
        return $this->public;
    }

    /**
     * Contains the hex-encoded public key if returned by Derive Address in Wallet endpoint. Optional.
     *
     * @param string $public
     * @return $this
     */
    public function setPublic($public)
    {
        $this->public = $public;
        return $this;
    }
}