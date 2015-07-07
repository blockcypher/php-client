<?php

namespace BlockCypher\Api;

use BlockCypher\Common\BlockCypherModel;

/**
 * Class Error
 *
 * @package BlockCypher\Api
 *
 * @property string error
 */
class Error extends BlockCypherModel
{
    /**
     * @return string
     */
    public function getError()
    {
        return $this->error;
    }

    /**
     * @param string $error
     * @return $this
     */
    public function setError($error)
    {
        $this->error = $error;
        return $this;
    }
}