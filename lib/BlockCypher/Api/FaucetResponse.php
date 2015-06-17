<?php

namespace BlockCypher\Api;

use BlockCypher\Common\BlockCypherResourceModel;

/**
 * Class FaucetResponse
 *
 * An AddressKeyChain represents an associated collection of public and private keys alongside their respective
 * public address. Generally returned and used with the Generate Address Endpoint.
 *
 * @package BlockCypher\Api
 *
 * @property string tx_ref
 */
class FaucetResponse extends BlockCypherResourceModel
{
    /**
     * @return string
     */
    public function getTxRef()
    {
        return $this->tx_ref;
    }

    /**
     * @param string $tx_ref
     * @return $this
     */
    public function setTxRef($tx_ref)
    {
        $this->tx_ref = $tx_ref;
    }
}