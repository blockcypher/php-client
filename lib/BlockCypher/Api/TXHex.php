<?php

namespace BlockCypher\Api;

use BlockCypher\Common\BlockCypherResourceModel;

/**
 * Class TXHex
 *
 * A TXHex represents a raw hex transaction.
 *
 * @package BlockCypher\Api
 *
 * @property string tx
 */
class TXHex extends BlockCypherResourceModel
{
    /**
     * @return string
     */
    public function getTx()
    {
        return $this->tx;
    }

    /**
     * @param string $tx
     * @return $this
     */
    public function setTx($tx)
    {
        $this->tx = $tx;
        return $this;
    }
}