<?php

namespace BlockCypher\Api;

use BlockCypher\Common\BlockCypherBaseModel;

/**
 * Class HDChain
 *
 * An array of HDChains are included in every HDWallet and returned from the Get Wallet,
 * Get Wallet Addresses and Derive Address in Wallet endpoints.
 *
 * @package BlockCypher\Api
 *
 * @property \BlockCypher\Api\HDAddress[] chain_addresses
 * @property int index
 */
class HDChain extends BlockCypherBaseModel
{
    /**
     * Array of HDAddresses associated with this subchain.
     *
     * @return \BlockCypher\Api\HDAddress[]
     */
    public function getChainAddresses()
    {
        return $this->chain_addresses;
    }

    /**
     * Array of HDAddresses associated with this subchain.
     *
     * @param \BlockCypher\Api\HDAddress[]
     * @return $this
     */
    public function setChainAddresses($chain_addresses)
    {
        $this->chain_addresses = $chain_addresses;
        return $this;
    }

    /**
     * Index of the subchain, returned if the wallet has subchains. Optional.
     *
     * @return int
     */
    public function getIndex()
    {
        return $this->index;
    }

    /**
     * Index of the subchain, returned if the wallet has subchains. Optional.
     *
     * @param int
     * @return $this
     */
    public function setIndex($index)
    {
        $this->index = $index;
        return $this;
    }
}