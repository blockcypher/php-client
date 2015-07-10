<?php

namespace BlockCypher\Builder;

use BlockCypher\Api\TXInput;

/**
 * Class TXInputBuilder
 */
class TXInputBuilder
{
    /**
     * @var string[]
     */
    private $addresses;

    /**
     * @var string
     */
    private $scryptType;

    function __construct()
    {
        $this->addresses = array();
        $this->scryptType = null;
    }

    /**
     * @return TXInputBuilder
     */
    public static function aTXInput()
    {
        return new TXInputBuilder();
    }

    /**
     * @param string $scryptType
     * @return $this
     */
    public function withScryptType($scryptType)
    {
        $this->scryptType = $scryptType;
        return $this;
    }

    /**
     * @param string $address
     * @return $this
     */
    public function addAddress($address)
    {
        $this->addresses[] = $address;
        return $this;
    }

    /**
     * @return TXInput
     */
    public function build()
    {
        $txInput = new TXInput();

        $txInput->setAddresses($this->addresses);
        $txInput->setScriptType($this->scryptType);

        return $txInput;
    }
}