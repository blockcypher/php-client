<?php

namespace BlockCypher\Exception;

/**
 * Class BlockCypherConfigurationException
 *
 * @package BlockCypher\Exception
 */
class BlockCypherConfigurationException extends \Exception
{

    /**
     * Default Constructor
     *
     * @param string|null $message
     * @param int $code
     */
    public function __construct($message = null, $code = 0)
    {
        parent::__construct($message, $code);
    }
}